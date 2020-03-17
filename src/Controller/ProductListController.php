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
        $output = '';
        if($total_row > 0)
        {
            foreach($result as $row)
            {
                $output .= '<div class="col-lg-4 col-sm-6">
                <div class="product-item">
                    <div class="pi-pic">
                        <img src="'. $row['image_url'] .'" alt="">
                        <div class="sale pp-sale">Sale</div>
                        <div class="icon">
                            <i class="icon_heart_alt"></i>
                        </div>
                        <ul>
                            <li class="w-icon active"><a href="#"><i class="icon_bag_alt"></i></a></li>
                            <li class="quick-view"><a href="#">Voir</a></li>
                        </ul>
                    </div>
                    <div class="pi-text">
                        <div class="catagory-name">'. $row['category_name'] .'</div>
                        <a href="#">
                            <h5>'. $row['product_name'] .'</h5>
                        </a>
                        <div class="product-price">
                        '. $row['price'] .'
                        </div>
                    </div>
                </div>
            </div>';

                $product_name = $row['product_name'];
                $category_name = $row['category_name'];
                $product_image = $row['image_url'];
                $product_price = $row['price'];
                $product_desc = $row['description'];

            }
        }
        else
        {
            $output = '<h3>Aucun article trouvé</h3>';
        }

        //$twig->addGlobal('output', $output);
        $array_global = array(
            'category_name' => $category_name,
            'product_name' => $product_name,
            'product_image' => $product_image,
            'product_price' => $product_price,
            'product_desc' => $product_desc,
            'products' => $result,
            'product' => $row,
        );

        return $this->render('/shop.html.twig', $array_global);
        
        

    }




}