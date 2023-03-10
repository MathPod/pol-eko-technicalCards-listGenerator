<?php 


$connect = mysqli_connect('sql.server400620.nazwa.pl', 'server400620_generator', '1Zy(opC0d4') or die('Could not connect');
mysqli_query($connect,'SET NAMES utf8');
mysqli_select_db($connect,'server400620_generator');





   
function generateModelLanguagesDrivers($connect, $array, $array2, $name_pl_final, $tabelaDaneTechniczneName, $tabelaStart, $tabelaEnd) {
    // echo(gettype($array));
    // echo("<br />");
    $query_dane_techniczne_table = "SELECT model, languages, nazwa_www_en, nazwa_www_es FROM " .$tabelaDaneTechniczneName. " WHERE nazwa_www_pl = '$name_pl_final'";
    $result_dane_techniczne_table = mysqli_query($connect,$query_dane_techniczne_table) or die(mysqli_error($connect));
    $row_dane_techniczne_table = mysqli_fetch_array($result_dane_techniczne_table);
   
    
    $arrayAdd = Array (
        'name_pl' => $name_pl_final,
        'name_en' => $row_dane_techniczne_table['nazwa_www_en'],
        'name_es' => $row_dane_techniczne_table['nazwa_www_es'],
        'model' => $row_dane_techniczne_table['model'],
        'tabelaDaneTechniczne' => $tabelaDaneTechniczneName,
        'tableStart' => $tabelaStart,
        'tableEnd' => $tabelaEnd,
    );

    $licznik = count($array);
    $array[$licznik+1] = array($arrayAdd);
    return $array;
    

}




// input data  through array


$array = array();
$array2 = array(1,2,3,4,5,6);
$query= "SELECT id, name_pl, name_en, name_es, sterownik, dane_techniczne_db_table FROM all_products_list WHERE id > 16";
$result = mysqli_query($connect,$query) or die(mysqli_error($connect));

while($row = mysqli_fetch_array($result)) {

    $id = $row['id']; 
    $name_pl = $row['name_pl'];
    $name_en = $row['name_en'];
    $name_es = $row['name_es'];
    $sterownik_argument = $row['sterownik'];
    $sterownik = $row['sterownik'];
    $dane_techniczne_db_table = $row['dane_techniczne_db_table'];

    $tabelaDaneTechniczne = explode(",", $row['dane_techniczne_db_table']);
    $tabelaDaneTechniczneName = $tabelaDaneTechniczne[0];
    $tabelaStart = $tabelaDaneTechniczne[1];
    $tabelaEnd = $tabelaDaneTechniczne[2];

    $name_pl_final = null;


    if($sterownik !== null && $sterownik !== '-') {
        $sterownik = explode(',',$sterownik);

        for($i=0; $i<count($sterownik); $i++) {
            $name_pl_final = $name_pl . " " . $sterownik[$i];
            $array = generateModelLanguagesDrivers($connect, $array, $array2, $name_pl_final, $tabelaDaneTechniczneName, $tabelaStart, $tabelaEnd);  
        } 

    } else {
        $name_pl_final = $name_pl;
        $array = generateModelLanguagesDrivers($connect, $array, $array2, $name_pl_final, $tabelaDaneTechniczneName, $tabelaStart, $tabelaEnd);
    };

    
    
}

print_r($array);




// encode array to json
// $json = json_encode($array);

// display it 
// echo "$json";

//generate json file
// file_put_contents("/devicesData_cardGenerator.json", $json);
  
?>