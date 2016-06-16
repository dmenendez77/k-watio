<?php
function getStateCode()
{
    $stateCode = array(1=> "ES-AN", //Andalucia
        "ES-AR" ,	//Aragón
        "ES-AS" ,	//Asturias, Principado de
        "ES-CN" ,	//Canarias
        "ES-CB" ,	//Cantabria
        "ES-CM" ,	//Castilla-La Mancha
        "ES-CL" ,	//Castilla y León
        "ES-CT" ,	//Catalunya (Cataluña)
        "ES-EX" ,	//Extremadura
        "ES-GA" ,	//Galicia
        "ES-IB" ,	//Illes Balears (Islas Baleares)
        "ES-RI" ,	//La Rioja
        "ES-MD" ,	//Madrid, Comunidad de
        "ES-MC" ,	//Murcia, Región de
        "ES-NC" ,	//Navarra, Comunidad Foral de / Nafarroako Foru Komunitatea
        "ES-PV" ,	//País Vasco / Euskal Herria
        "ES-VC");     //Valenciana, Comunidad / Valenciana, Comunitat
    retunr $stateCode;
}
function getStateName()
{
    $stateName = array(1=> "Andalucia" ,
        "Aragón",
        "Asturias, Principado de",
        "Canarias",
        "Cantabria",
        "Castilla-La Mancha",
        "Castulla y León",
        "Cataluña",
        "Extremadura",
        "Galicia",
        "Islas Baleares",
        "La Rioja",
        "Comunidad de Madrid",
        "Región de Murcia",
        "Comunidad Foral de Navarra",
        "País Vasco",
        "Comunidad Valenciana");
    return $stateName;
}
?>
    