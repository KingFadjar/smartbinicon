<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeleteData; // Import the DeleteData model

class DeleteDataController extends Controller
{
    public function deleteData(Request $request)
    {
        try {
            // Get the selected IDs
            $selectedIds = $request->input('ids');

            // Perform deletion logic using the selected IDs
            DeleteData::whereIn('id', $selectedIds)->delete();

            return response()->json(['message' => 'Selected data deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error deleting data'], 500);
        }
    }
}

