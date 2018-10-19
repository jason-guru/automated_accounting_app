<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brotzka\DotenvEditor\DotenvEditor;
use Brotzka\DotenvEditor\Exceptions\DotEnvException;

class AppSettingsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $env = new DotenvEditor();
        $data['values'] = $env->getContent();
        //$data['json'] = json_encode($data['values']);
        try{
            $data['backups'] = $env->getBackupVersions();
        } catch(DotEnvException $e){
            $data['backups'] = false;
        }

        $data['url'] = $request->path();
        return view('vendor.dotenv-editor.overview', $data);
    }
}
