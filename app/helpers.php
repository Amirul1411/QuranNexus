<?php

use MongoDB\Operation\FindOneAndUpdate;
use MongoDB\Client as MongoClient;

if (!function_exists('getNextSequenceValue')) {
    function getNextSequenceValue($sequenceName)
    {
        // Get the MongoDB client
        $client = new MongoClient(env('DB_URI'));
        $database = $client->selectDatabase(env('DB_DATABASE'));
        $collection = $database->selectCollection('counters');

        $sequenceDocument = $collection->findOneAndUpdate(
            ['_id' => $sequenceName],
            ['$inc' => ['sequence_value' => 1]],
            ['returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER, 'upsert' => true]
        );

        return $sequenceDocument->sequence_value;
    }
}
