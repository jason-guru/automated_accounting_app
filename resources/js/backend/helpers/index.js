import Vue from 'vue';
export default{
    install(){
        Vue.mixin({
            methods: {
                elementUiDateConvert(date){
                    var prepDate = new Date(date);
                    prepDate.setDate(prepDate.getDate() + 1);
                    return prepDate.toISOString().substring(0,10);
                },
            }
        })
    }
}