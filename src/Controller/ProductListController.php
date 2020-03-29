<?php
namespace App\Controller;

use PDO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductListController extends AbstractController
{

    /**
     * @Route("/courses-en-ligne", name="viewRayon")
     */
    public function viewRayon()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $twig = new \Twig\Environment($loader);
        $connect = new PDO("mysql:host=localhost;dbname=momoprixdb", "root", "");

        $query = "SELECT * 
        FROM product
        LEFT JOIN category ON product.id = category.id
        WHERE stock > '0'";
        $statement = $connect->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $total_row = $statement->rowCount();
        $products = [];
        if($total_row > 0)
        {
            foreach($result as $row)
            {
                array_push($products, 
                    [
                        'Category' => $row['category_name'],
                        'Name' => $row['product_name'],
                        'Price' => $row['price'],
                        'Description' => $row['description'],
                        'Image_url' => $row['image_url']
                    ]
                );
            }
            //$productsList[] = json_encode($products);
            //print_r($productsList);die;
        }
        else
        {
            $products = ['error' => 'Aucun produits trouvé'];
            //$productsList = ['error' => 'Aucun produits trouvé'];
        }

        return $this->render('/shop.html.twig', array('products'=>$products, ));
        
        

    }




}