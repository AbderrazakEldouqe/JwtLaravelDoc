<?php


namespace App\Helpers;


class AppHelper
{
    public static function loginError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
        ], 401);
    }

    public static function logoutSuccess()
    {
        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully'
        ]);
    }

    public static function logoutError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, the user cannot be logged out'
        ], 500);
    }

    public static function registerError()
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, User could not be added '
        ], 500);
    }

    public static function notFoundError($id, $modelName)
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, ' . $modelName . ' with id ' . $id . ' cannot be found.'
        ], 404);
    }

    public static function storeError($modelName)
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, ' . $modelName . ' could not be added '
        ], 500);
    }

    public static function updateError($id, $modelName)
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, ' . $modelName . ' with id ' . $id . ' could not be updated '
        ], 500);
    }

    public static function deleteError($id, $modelName)
    {
        return response()->json([
            'success' => false,
            'message' => 'Sorry, ' . $modelName . ' with id ' . $id . ' could not be deleted '
        ], 500);
    }

    public static function deleteSuccess($id, $modelName)
    {
        return response()->json([
            'success' => true,
            'message' => $modelName . ' with id ' . $id . ' has been deleted '
        ], 200);
    }
}
