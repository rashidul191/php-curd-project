<?php

define('DB_NAME', "data/db.txt");

$students = array(
    array(
        "id" => "ab1",
        "name" => "Rashidul Islam",
        "roll" => 1,
        "age" => 25,
    ),
    array(
        "id" => "ab2",
        "name" => "Abdur Rouf Sorker",
        "roll" => 2,
        "age" => 30,
    ),
    array(
        "id" => "ab3",
        "name" => "Rakib Islam",
        "roll" => 3,
        "age" => 20,
    ),
    array(
        "id" => "ab4",
        "name" => "Rafiul Islam",
        "roll" => 4,
        "age" => 12,
    ),

);


function putData($filePathName)
{
    global $students;
    $serializeData = serialize($students);
    file_put_contents($filePathName, $serializeData, LOCK_EX);
}

function getAllStudents($filePathName)
{
    $data = file_get_contents($filePathName);
    $unserializeData = unserialize($data);
    return $unserializeData;
}

function getNewID()
{
    return substr(uniqid(), 8, -1,);
}

function addStudent($name, $age, $roll)
{
    $_found = false;
    $data = file_get_contents(DB_NAME);
    $unserializeData = unserialize($data);
    foreach ($unserializeData as $student) {
        if ($roll == $student["roll"]) {
            $_found = true;
        }
    }
    if (!$_found) {
        $newId = getNewID();
        $student = array(
            "id" => $newId,
            "name" => $name,
            "roll" => $roll,
            "age" => $age,
        );
        array_push($unserializeData, $student);
        $serializeData = serialize($unserializeData);
        file_put_contents(DB_NAME, $serializeData, LOCK_EX);
        return true;
    }
    return false;
}

function getStudent($id)
{
    $unserializeData = file_get_contents(DB_NAME);
    $studentsData = unserialize($unserializeData);

    foreach ($studentsData as $student) {
        if ($id == $student['id']) {
            return $student;
        }
    }

    return false;
}

function updateStudentData($id, $name, $age, $roll)
{
    $unserializeData = file_get_contents(DB_NAME);
    $studentsData = unserialize($unserializeData);

    $dataLength = count($studentsData);

    for ($i = 0; $i < $dataLength; $i++) {
        if ($id == $studentsData[$i]["id"]) {
            $studentsData[$i]['name'] = $name;
            $studentsData[$i]['roll'] = $roll;
            $studentsData[$i]['age'] = $age;
            break;
        }
    }
    $serializeData = serialize($studentsData);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX);

    // $index = -1;
    // foreach ($studentsData as $key => $student) {

    //     if ($id == $student['id']) {
    //         $index = $key;
    //     }
    // }
    // if ($index !== -1) {
    //     // unset($studentsData[$index]);
    //     $studentsData[$index]['name'] = $name;
    //     $studentsData[$index]['roll'] = $roll;
    //     $studentsData[$index]['age'] = $age;
    //     $serializeData = serialize($studentsData);
    //     file_put_contents(DB_NAME, $serializeData, LOCK_EX);
    // }
}

function deleteStudentsData($id)
{

    $unserializeData = file_get_contents(DB_NAME);

    $studentsData = unserialize($unserializeData);
    $dataLength = count($studentsData);
    for ($i = 0; $i < $dataLength; $i++) {
        if ($id == $studentsData[$i]["id"]) {
            unset($studentsData[$i]);
            break;
        }
    }
    $serializeData = serialize($studentsData);
    file_put_contents(DB_NAME, $serializeData, LOCK_EX);

    // $index = -1;
    // foreach ($studentsData as $key => $student) {

    //     if ($id == $student['id']) {
    //         $index = $key;
    //     }
    // }
    // if ($index !== -1) {
    //     unset($studentsData[$index]);
    //     $serializeData = serialize($studentsData);
    //     file_put_contents(DB_NAME, $serializeData, LOCK_EX);
    // }

}
