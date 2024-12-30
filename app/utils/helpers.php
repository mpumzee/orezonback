<?php

function successResponseHandler($msg, $data){
    return response()->json([
        'status' => 'success',
        'message' => $msg,
        'data' => $data
    ], 200);
}

function createdResponseHandler($msg, $data){
    return response()->json([
        'status' => 'created',
        'message' => $msg,
        'data' => $data
    ], 201);
}

function errorResponseHandler($msg, $data=[])
{
    return response()->json([
        'status' => 'error',
        'message' => $msg,
        'data' => $data
    ], 500);
}

function errorValidationResponseHandler($msg, $data=[])
{
    return response()->json([
        'status' => 'error',
        'message' => $msg,
        'data' => $data
    ], 400);
}

function deleteSuccessHandler($msg, $data=[])
{
    return response()->json([
        'status' => 'success',
        'message' => $msg,
        'data' => $data
    ], 200);
}

function notFoundResponseHandler($msg, $data=[])
{
    return response()->json([
        'status' => 'error',
        'message' => $msg,
        'data' => $data
    ], 404);
}
