<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Elasticsearch\ClientBuilder;
use App\Models\Product;

class ImportToElasticSearch extends Command
{

    const ELASTIC_INDEX = "products";
    const ELASTIC_TYPE  = "product";

    protected $client;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data-to-elasticsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports all data from database to Elasticsearch service';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        // Initialize Elasticsearch client
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
         // When importing, delete old data and insert new from database
        $reset = $this->resetIndex();

        if ($reset) {
            echo "========= Import Start ============" . PHP_EOL;
            $start_time = microtime(true);
            $total = $this->importProducts();
            $end_time = microtime(true);
            echo "========= Import End ==============" . PHP_EOL;
            echo "Time elapsed: " . round($end_time-$start_time, 2) . ' seconds' . PHP_EOL;
            echo "Total " . $total . " jobs were imported to ElasticSearch" . PHP_EOL;
        } else {
            echo "Data is not imported";
        }
    }

    public function resetIndex() {
        $params = [
            'index' => Product::ELASTIC_INDEX
        ];

        // If index exists it will delete it (all data will be deleted) and create new one
        if ($this->client->indices()->exists($params)) {

            // Deleting index
            $response_delete = $this->client->indices()->delete($params);

            if ($response_delete['acknowledged']) {
                echo "Index '" . Product::ELASTIC_INDEX . "' successfully deleted" . PHP_EOL;

                // Creating new index
                $response_create = $this->client->indices()->create($params);

                if ($response_create['acknowledged']) {
                    echo "Index '" . Product::ELASTIC_INDEX . "' successfully created" . PHP_EOL;
                    return true;
                }

                echo "Failed to create index" . PHP_EOL;
                die();
            }

            echo "Failed to delete index" . PHP_EOL;
            die();
        } else {
            // Creating new index
            $response_create = $this->client->indices()->create($params);

            if ($response_create['acknowledged']) {
                return true;
            }

            echo "Failed to create index" . PHP_EOL;
            die();
        }
    }

    private function importProducts() {
        $start = microtime(true);

        // Get all product data from database
        $products = Product::all();

        $end = microtime(true);

        $i = 0;
        echo "-- Got data in " . round($end - $start, 2) . " seconds" . PHP_EOL;

        $start = microtime(true);
        foreach ($products as $product) {

            // Add index and type data to array
            $data['body'][] = [
                'index' => [
                    '_index'    => Product::ELASTIC_INDEX,
                    '_type'     => Product::ELASTIC_TYPE
                ]
            ];

            // Movie data that will be required for later search
            $data['body'][] = [
                'id'            => $product->id,
                'uuid'          => $product->uuid,
                'name'          => $product->name,
                'price'         => $product->price,
                'image_path'    => $product->image_path,
                'type'          => $product->type,
                'subtype'       => $product->subtype
            ];

            $i++;
        }
        $end = microtime(true);
        echo "-- Filled array in " . round($end - $start, 2) . " seconds" . PHP_EOL;

        $start = microtime(true);

        // Execute Elasticsearch bulk command for indexing multiple data
        $response = $this->client->bulk($data);

        $end = microtime(true);
        echo "-- Uploaded in " . round($end - $start, 2) . " seconds" . PHP_EOL;
        return $i;
    }
}
