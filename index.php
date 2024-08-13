<?php

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;



$consumer_key = "ck_e543df6714b758d88839cd8b1baf1e7c84b16e59";
$consumer_secret = "cs_1ec97cddb3df5a259c32686ba0e8934406af6db2";

$woocommerce = new Client(
  'http://localhost/woocommercedemo/',
  $consumer_key,
  $consumer_secret,
  [
    'version' => 'wc/v3',
  ]
);



$data = [
    'name' => 'Premium Quality',
    'type' => 'simple',
    'regular_price' => '299.99',
    'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
    'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
    'categories' => [
        // ['id' => 9],
        ['id' => 16]
    ],
    'images' => [
        ['src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg']
    ]
];

//print_r($woocommerce->post('products', $data));


// ** Update the products data **
$data = [
    'regular_price' => '299.45',
    'sale_price' => '199.59',
     'images' => [
        ['src' => 'http://localhost/woocommercedemo/wp-content/uploads/2022/10/firstt-shirt.jpg']
    ]

];

print_r($woocommerce->put('products/34', $data));



// ** Get the Specific products using ID **
$product_ids = [80, 34];
$response = $woocommerce->get('products', [
    'per_page' => 99,
    'include' => implode(',', $product_ids),
    
]);
foreach ($response as $product) {
    // $product_id = $product->id; // Accessing the product ID correctly
    // echo "<pre>";
    // print_r($product);
}


//**Get the products using single ID only
 // print_r($woocommerce->get('products/80'));


//**Get the particular products with the categories id and products id
$product_ids = [80, 34];
$product_categories = [19, 20];


$response_ids = $woocommerce->get('products', [
    'per_page' => 99,
    'include' => implode(',', $product_ids)
]);
$response_categories = $woocommerce->get('products', [
    'per_page' => 99,
    'category' => implode(',', $product_categories)
]);
  $merged_products = array_merge($response_ids, $response_categories);

foreach ($merged_products as $product) {
  echo "<pre>";
  print_r($product);
}

//Delete the Particular Products
echo "<pre>";
// print_r($woocommerce->delete('products/79', ['force' => true])); 



//Deleted the Multiple Products
// $product_ids = [154, 155];
echo "<pre>";
foreach ($product_ids as $product_id) {
    $response = $woocommerce->delete('products/' . $product_id, ['force' => true]);

    if (!empty($response) && isset($response->id)) {
        // Product deleted successfully
        echo "Product ID {$product_id} deleted successfully.\n";
        print_r($response);
    } else {
        // Product not deleted
        echo "Failed to delete Product ID {$product_id}.\n";
        print_r($response);
    }
}

echo "</pre>";


//Batch Updated Productcs
$data = [
    'create' => [
        [
            'name' => 'test one',
            'type' => 'simple',
            'regular_price' => '21.99',
            'virtual' => true,
            'downloadable' => true,
            'downloads' => [
                [
                    'name' => 'Test one',
                    'file' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/cd_4_angle.jpg'
                ]
            ],
            'categories' => [
                [
                    'id' => 18
                ],
                [
                    'id' => 20
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/cd_4_angle.jpg'
                ]
            ]
        ],
        [
            'name' => 'Test Two',
            'type' => 'simple',
            'regular_price' => '21.99',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 18
                ],
                [
                    'id' => 20
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
                ]
            ]
        ]
    ],
    'update' => [
        [
            'id' => 165,
            'regular_price' => '299.45',  // Regular price of the product
            'sale_price' => '199.59',     // Sale price of the product
        ]
    ],
    'delete' => [
        169
    ]
];

print_r($woocommerce->post('products/batch', $data));
  
