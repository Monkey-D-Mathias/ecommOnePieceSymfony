<?

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/xhr/', name : 'app_xhr_')]
class XhrControllerCour extends AbstractController
{
    #[Route('cart/add/{id}', name : 'cart_add', methods: 'POST')]
    public function cartAdd(string $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
           return new Response("Product not found", 404);
        }

        //TRAITEMENT POUR AJOUTER LE PRODUIT DANS LE PANIER
        return new Response("Product add to cart");
    }
}