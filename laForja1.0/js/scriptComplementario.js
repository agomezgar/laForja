var xhrTabla;
var cuentaInstrumentosEvaluacion=0;
function generaTabla(numero,cuenta){

if(window.ActiveXObject){
xhrTabla=new ActiveXObject("Microsoft.XMLHttp");
}
else if((window.XMLHttpRequest)||(typeof XMLHttpRequest)!=undefined){
xhrTabla=new XMLHttpRequest();
}
else {
alert ("Su navegador no soporta AJAX");
return;
}





try{
var numero2=numero.toString();
//alert (numero2);
var cadena="<table>";

var seleccion=document.getElementById(numero2).value;
//alert("trim"+cuenta);
var e=document.getElementById("trim"+cuenta);
var trimSel= (e.options[e.selectedIndex].value);
for (var i=0;i<parseInt(seleccion);i++){
cuentaInstrumentosEvaluacion++;
var nombreCriterio="criterio["+cuentaInstrumentosEvaluacion+"]";
var nombreContenido="contenido["+cuentaInstrumentosEvaluacion+"]";
var nombreTrimestre="trimestre["+cuentaInstrumentosEvaluacion+"]";
alert (nombreInput);
cadena+="<tr><td> <input name=\""+nombreCriterio+"\" type=\"text\" value=\"Examen"+cuentaInstrumentosEvaluacion+" \" /></td><input type=\"hidden\" name=\""+nombreContenido+"\" value=\""+cuenta+"\"><input type=\"hidden\" name=\""+nombreTrimestre+"\" value=\""+trimSel+"\"></tr>";
}
cadena=cadena+"</table><br>Mierda, no sale";
var numeroCuenta=numero2;
var nombreTabla="Tabla"+numero2;
//alert(nombreTabla);
document.getElementById(nombreTabla).innerHTML=cadena;
//document.getElementById(numeroCuenta).innerHTML="hola";
document.getElementById("Cuenta").innerHTML="<input type=\"hidden\" name=\"nInstrumentos\" value=\""+cuentaInstrumentosEvaluacion+"\">";
//alert(cuentaInstrumentosEvaluacion);

}catch(e){
alert(e);
}
//enviapeticionMateria();
}
