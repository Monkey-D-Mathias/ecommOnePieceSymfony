/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
//import './styles/app.css';

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap';

document.addEventListener('DOMContentLoaded', function(event){
    let addToCartButton = document.getElementsByClassName('add-to-cart');
    Array.from(addToCartButton).forEach(function(element){
        element.addEventListener('click', function(event){
            event.preventDefault();
    
            let elementId = event.target.id;
            let id = elementId.replace('product-', '');
            console.log(id);
            addToCart(id)
        })
    });
    let addToCart = function(id){
        let xhr = new XMLHttpRequest();
        let url = "/xhr/cart/add/";
        xhr.open('POST', url+id);
        xhr.send();
    
        // La requete est passe, on traite le retour serveur
        xhr.onload = function () {
            if (xhr.status == 200) {
                // Tout c'est bien passé
                alert(xhr.response);
            }
            else{
                // On a une erreur http
                alert(xhr.status + ' - ' + xhr.responseText);
            }
        };
        // La requete n'est pas passé
        xhr.onerror = function() {
            alert("XHR ERROR");
        };
        // La requete est en cours
        xhr.onprogress = function() {
            console.log("Chargement");
        };
    }
    
})
