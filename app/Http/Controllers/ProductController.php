<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Elasticsearch\ClientBuilder;

class ProductController extends Controller
{
	protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function getAllProducts(Request $request) {
  //   	$params = [
		//     'index' => Product::ELASTIC_INDEX,
		//     'id'    => Product::ELASTIC_TYPE
		// ];
		// print_r($params);

		// $source = $this->client->getSource($params);
    	// return Product::all();

    	return $this->search("*");
    }

    public function searchType(Request $request) {
    	if($request->has('q') && $request->input('q')) {
    		$q = strtolower($request->input('q'));
	    	$params = [
		        'index' => Product::ELASTIC_INDEX,
		        'type' => Product::ELASTIC_TYPE,
		        'body' => [
		            'sort' => [
		                '_score'
		            ],
		            'query' => [
                        'match' => [
                        	'subtype' => $q
                        ]
		            ]

		         ]
		    ];
		    $data = $this->client->search($params);
		    $productArray = [];

	        if($data['hits']['total'] > 0) {
	            foreach ($data['hits']['hits'] as $hit) {
	                $productArray[] = $hit['_source'];
	            }
	        }

	        return $productArray;
    	}
    }

    public function search($q) {
	    // if($request->has('q') && $request->input('q')) {
	        // Search for given text and return data
	        $data = $this->searchProducts($q);
	        $productArray = [];

	        if($data['hits']['total'] > 0) {
	            foreach ($data['hits']['hits'] as $hit) {
	                $productArray[] = $hit['_source'];
	            }
	        }

	        return $productArray;
	    /*} else {
	        return "No q!";
	    }*/
	}

	public function searchTerm(Request $request) {
	    if($request->has('q') && $request->input('q')) {
	        // Search for given text and return data
	        $data = $this->searchProducts("*".$request->input('q')."*");
	        
	    } else {
	        $data = $this->searchProducts("*");
	    }
	    $productArray = [];

	        if($data['hits']['total'] > 0) {
	            foreach ($data['hits']['hits'] as $hit) {
	                $productArray[] = $hit['_source'];
	            }
	        }

	        return $productArray;
	}


	private function searchProducts($text) {
	    $params = [
	        'index' => Product::ELASTIC_INDEX,
	        'type' => Product::ELASTIC_TYPE,
	        'body' => [
	            'sort' => [
	                '_score'
	            ],
	            'query' => [

	                'wildcard' => [
	                    'name' => [
	                        'value'     => $text
	                    ]
	                ]
	            ]

	         ]
	    ];
	    $data = $this->client->search($params);
	    return $data;
	}
}
