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

    public function getAllProducts() {
  //   	$params = [
		//     'index' => Product::ELASTIC_INDEX,
		//     'id'    => Product::ELASTIC_TYPE
		// ];
		// print_r($params);

		// $source = $this->client->getSource($params);
    	return Product::all();
    }

    public function search(Request $request) {
	    if($request->has('q') && $request->input('q')) {
	        // Search for given text and return data
	        $data = $this->searchProducts($request->input('q'));
	        $productArray = [];

	        if($data['hits']['total'] > 0) {
	            foreach ($data['hits']['hits'] as $hit) {
	                $productArray[] = $hit['_source'];
	            }
	        }

	        return $productArray;
	    } else {
	        return "No q!";
	    }
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
	               'bool' => [
	                   'should' => [
	                        ['match' => [
	                            'name' => [
	                               'query'     => $text,
	                               'fuzziness' => '2'
	                            ]
	                        ]],
	                        ['match' => [
	                            'price' => [
	                                'query'     => $text,
	                                'fuzziness' => '1'
	                            ]
	                        ]]
	                   ]
	                ],
	            ],
	         ]
	    ];
	    $data = $this->client->search($params);
	    return $data;
	}
}
