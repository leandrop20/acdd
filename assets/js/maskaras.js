/* Máscaras ER */
function maskTel(o,f){
    v_obj = o;
    v_fun = mtel;
    setTimeout("execmascara()",1);
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function checkPassword(obj, ref)
{
    if ($("#"+ref).val() != obj.value) {
        obj.setCustomValidity("Repita a mesma senha");
    } else {
        obj.setCustomValidity("");
    }
}
function checkPasswordEdit(obj, ref)
{
    if (obj.value.length > 0) {
        $("#"+ref).attr("required", true);
    } else {
        $("#"+ref).attr("required", false);
    }
}