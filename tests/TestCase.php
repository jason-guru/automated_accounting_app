<?php

namespace Tests;

use Carbon\Carbon;
use App\Models\Deadline;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Spatie\Permission\Models\Permission;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create the admin role or return it if it already exists.
     *
     * @return mixed
     */
    protected function getAdminRole()
    {
        if ($role = Role::whereName(config('access.users.admin_role'))->first()) {
            return $role;
        }

        $adminRole = factory(Role::class)->create(['name' => config('access.users.admin_role')]);
        $adminRole->givePermissionTo(factory(Permission::class)->create(['name' => 'view backend']));

        return $adminRole;
    }

    /**
     * Create an administrator.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    protected function createAdmin(array $attributes = [])
    {
        $adminRole = $this->getAdminRole();
        $admin = factory(User::class)->create($attributes);
        $admin->assignRole($adminRole);

        return $admin;
    }

    /**
     * Login the given administrator or create the first if none supplied.
     *
     * @param bool $admin
     *
     * @return bool|mixed
     */
    protected function loginAsAdmin($admin = false)
    {
        if (! $admin) {
            $admin = $this->createAdmin();
        }

        $this->actingAs($admin);

        return $admin;
    }

    protected function setUpClientWithDeadline($companyNumber)
    {
        $clientRepository = new ClientRepository();
        $this->loginAsAdmin();
        $deadline = factory(Deadline::class)->create([
            'name' => 'paye',
            'code' => config('deadline.code.0')
        ]);
        $this->post('/admin/clients', [
            'company_number' => $companyNumber,
            'company_name' => "Oxmonk",
            'company_type_id' => 1,
            'accounts_next_due' => Carbon::parse('+1 year'),
            'accounts_overdue' => false,
            'country_id' => 1,
            'phone' => "8794515903",
            'email' => "admin@admin.com",
            'is_api' => true
        ]);
        $client = $clientRepository->getById(1);
        $this->post('/admin/client/deadline', [
            'client_id' => $client->id,
            'deadline_id'=> $deadline->id,
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => '2019-03-21'
        ]);
        return $client;
    }
}
