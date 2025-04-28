<?php
require_once '../includes/dbconnect.php';

// Fonction pour créer les tables
function createTables($pdo) {
    $queries = [
        "DROP DATABASE IF EXISTS clickandsport;",
        "CREATE DATABASE clickandsport;",
        "USE clickandsport;",
        "CREATE TABLE users(
           user_id INT AUTO_INCREMENT PRIMARY KEY,
           name VARCHAR(100) NOT NULL,
           firstname VARCHAR(100) NOT NULL,
           email VARCHAR(255) NOT NULL,
           phone_number VARCHAR(20) NOT NULL,
           password VARCHAR(50) NOT NULL,
           UNIQUE(email),
           UNIQUE(password)
        );
        
        CREATE TABLE categories(
           categorie_id INT AUTO_INCREMENT PRIMARY KEY,
           title_categorie VARCHAR(100) NOT NULL,
           description TEXT NOT NULL
        );
        
        CREATE TABLE address(
           address_id INT AUTO_INCREMENT PRIMARY KEY,
           city VARCHAR(255) NOT NULL,
           zipcode CHAR(5) NOT NULL,
           type VARCHAR(50),
           address VARCHAR(255) NOT NULL,
           user_id INT NOT NULL,
           FOREIGN KEY(user_id) REFERENCES users(user_id)
        );
        
        CREATE TABLE products(
           product_id INT AUTO_INCREMENT PRIMARY KEY,
           title_product VARCHAR(100) NOT NULL,
           price DECIMAL(10,2) NOT NULL,
           description TEXT NOT NULL,
           stock_quantity INT NOT NULL,
           avis INT(1) NOT NULL,
           categorie_id INT NOT NULL,
           FOREIGN KEY(categorie_id) REFERENCES categories(categorie_id)
        );
        
        CREATE TABLE orders(
           order_id INT AUTO_INCREMENT PRIMARY KEY,
           statut VARCHAR(50) NOT NULL,
           date_order DATETIME NOT NULL,
           total_amount DECIMAL(15,2),
           mode_paiement VARCHAR(50),
           date_ VARCHAR(50),
           address_id INT NOT NULL,
           user_id INT NOT NULL,
           FOREIGN KEY(address_id) REFERENCES address(address_id),
           FOREIGN KEY(user_id) REFERENCES users(user_id)
        );
        
        CREATE TABLE picture(
           picture_id INT AUTO_INCREMENT PRIMARY KEY,
           title_picture VARCHAR(100) NOT NULL,
           product_id INT NOT NULL,
           FOREIGN KEY(product_id) REFERENCES products(product_id)
        );
        
        CREATE TABLE colors(
           color_id INT AUTO_INCREMENT PRIMARY KEY,
           title_colors VARCHAR(100) NOT NULL,
           product_id INT NOT NULL,
           FOREIGN KEY(product_id) REFERENCES products(product_id)
        );
        
        CREATE TABLE size(
           size_id INT AUTO_INCREMENT PRIMARY KEY,
           title_size VARCHAR(50),
           product_id INT NOT NULL,
           FOREIGN KEY(product_id) REFERENCES products(product_id)
        );
        
        CREATE TABLE stocker(
           product_id INT,
           order_id INT,
           PRIMARY KEY(product_id, order_id),
           FOREIGN KEY(product_id) REFERENCES products(product_id),
           FOREIGN KEY(order_id) REFERENCES orders(order_id)
        );
        
        CREATE TABLE Evaluer(
           user_id INT,
           product_id INT,
           rating INT(1) NOT NULL,
           date_rating DATETIME NOT NULL,
           PRIMARY KEY(user_id, product_id),
           FOREIGN KEY(user_id) REFERENCES users(user_id),
           FOREIGN KEY(product_id) REFERENCES products(product_id)
        );
        
        CREATE TABLE aimer(
           user_id INT,
           product_id INT,
           PRIMARY KEY(user_id, product_id),
           FOREIGN KEY(user_id) REFERENCES users(user_id),
           FOREIGN KEY(product_id) REFERENCES products(product_id)
);"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
    }
}

// Fonction pour insérer des auteurs
function insertUsers($pdo) {
    $users = [
        ['morvin', 'LeBG', 'morvin@lebg.fr','06.01.02.03.04', 'azerty']
    ];

    $stmt = $pdo->prepare("INSERT INTO users (name, firstname, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
    foreach ($users as $user) {
        $stmt->execute($user);
    }
}

// Fonction pour insérer des catégories
function insertCategories($pdo) {
    $categories = [
        ['Football', 'Articles de football'],
        ['Basketball', 'Articles de basketball'],
        ['golf', 'Articles de golf'],
        ['tennis', 'Articles de tennis']
    ];

    $stmt = $pdo->prepare("INSERT INTO categories (title_categorie, description) VALUES (?, ?)");
    foreach ($categories as $category) {
        $stmt->execute($category);
    }
}


// Function to insert addresses
function insertAddresses($pdo) {
    $addresses = [
        ['Paris', '75001', 'Facturation', '15 Rue de la Paix', 1],
        ['Paris', '75002', 'Livraison', '23 Boulevard des Capucines', 1],
        ['Lyon', '69001', 'Facturation', '7 Place Bellecour', 1],
        ['Marseille', '13001', 'Livraison', '45 La Canebière', 1]
    ];

    $stmt = $pdo->prepare("INSERT INTO address (city, zipcode, type, address, user_id) VALUES (?, ?, ?, ?, ?)");
    foreach ($addresses as $address) {
        $stmt->execute($address);
    }
}

// Function to insert products
function insertProducts($pdo) {
    $products = [
        // Football products (category_id = 1)
        ['Ballon de football professionnel', 39.99, 'Ballon de football officiel, taille 5, parfait pour les matchs et les entraînements.', 50, 4, 1],
        ['Maillot équipe de France', 89.99, 'Maillot officiel de l\'équipe de France, collection 2024.', 100, 5, 1],
        ['Chaussures de football à crampons', 119.99, 'Chaussures de football haute performance avec crampons pour terrain sec.', 30, 4, 1],
        ['Gants de gardien de but', 29.99, 'Gants professionnels avec protection optimale pour les gardiens de but.', 25, 3, 1],
        ['Protège-tibias', 19.99, 'Protège-tibias légers et résistants pour une protection optimale.', 60, 4, 1],

        // Basketball products (category_id = 2)
        ['Ballon de basketball NBA', 49.99, 'Ballon officiel NBA, taille 7, parfait pour la compétition.', 40, 5, 2],
        ['Maillot Los Angeles Lakers', 79.99, 'Maillot officiel des Lakers, saison 2024.', 50, 5, 2],
        ['Chaussures de basketball', 129.99, 'Chaussures haute performance avec amorti pour les joueurs de basketball.', 35, 4, 2],
        ['Panier de basketball portable', 199.99, 'Panier de basketball réglable en hauteur, idéal pour le jardin.', 15, 4, 2],
        ['Shorts de basketball', 39.99, 'Shorts respirants et confortables pour la pratique du basketball.', 70, 4, 2],

        // Golf products (category_id = 3)
        ['Set de clubs de golf débutant', 299.99, 'Ensemble complet de clubs pour débutants, incluant un sac.', 20, 4, 3],
        ['Balles de golf premium', 24.99, 'Pack de 12 balles de golf haute performance.', 100, 5, 3],
        ['Gant de golf homme', 19.99, 'Gant de golf en cuir véritable pour une meilleure prise.', 50, 4, 3],
        ['Chaussures de golf imperméables', 149.99, 'Chaussures de golf imperméables avec crampons soft.', 30, 5, 3],
        ['Casquette de golf', 29.99, 'Casquette légère et respirante pour le golf.', 60, 4, 3],

        // Tennis products (category_id = 4)
        ['Raquette de tennis professionnelle', 179.99, 'Raquette de tennis en graphite pour joueur confirmé.', 25, 5, 4],
        ['Balles de tennis', 14.99, 'Tube de 3 balles de tennis pour tous types de surface.', 120, 4, 4],
        ['Chaussures de tennis tout terrain', 109.99, 'Chaussures conçues pour tous types de courts de tennis.', 40, 4, 4],
        ['Poignet éponge', 7.99, 'Pack de 2 poignets éponge pour absorber la transpiration.', 100, 3, 4],
        ['Sac de tennis 6 raquettes', 69.99, 'Sac spacieux pouvant contenir jusqu\'à 6 raquettes et accessoires.', 30, 4, 4]
    ];

    $stmt = $pdo->prepare("INSERT INTO products (title_product, price, description, stock_quantity, avis, categorie_id) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute($product);
    }
}

// Function to insert pictures
function insertPictures($pdo) {
    $pictures = [
        // Pictures for football products
        ['ballon_foot_pro.jpg', 1],
        ['ballon_foot_pro_angle.jpg', 1],
        ['maillot_france_avant.jpg', 2],
        ['maillot_france_arriere.jpg', 2],
        ['chaussures_foot_crampons.jpg', 3],
        ['gants_gardien_but.jpg', 4],
        ['protege_tibias.jpg', 5],

        // Pictures for basketball products
        ['ballon_nba.jpg', 6],
        ['maillot_lakers_avant.jpg', 7],
        ['maillot_lakers_arriere.jpg', 7],
        ['chaussures_basket.jpg', 8],
        ['panier_basket_portable.jpg', 9],
        ['shorts_basket.jpg', 10],

        // Pictures for golf products
        ['set_clubs_golf.jpg', 11],
        ['balles_golf.jpg', 12],
        ['gant_golf.jpg', 13],
        ['chaussures_golf.jpg', 14],
        ['casquette_golf.jpg', 15],

        // Pictures for tennis products
        ['raquette_tennis.jpg', 16],
        ['balles_tennis.jpg', 17],
        ['chaussures_tennis.jpg', 18],
        ['poignet_eponge.jpg', 19],
        ['sac_tennis.jpg', 20]
    ];

    $stmt = $pdo->prepare("INSERT INTO picture (title_picture, product_id) VALUES (?, ?)");
    foreach ($pictures as $picture) {
        $stmt->execute($picture);
    }
}

// Function to insert colors
function insertColors($pdo) {
    $colors = [
        ['Blanc', 1],
        ['Noir', 1],
        ['Bleu', 2],
        ['Blanc', 2],
        ['Rouge', 2],
        ['Noir', 3],
        ['Bleu', 3],
        ['Rouge', 3],
        ['Noir', 4],
        ['Blanc', 4],
        ['Noir', 5],
        ['Orange', 6],
        ['Jaune', 7],
        ['Violet', 7],
        ['Blanc', 8],
        ['Noir', 8],
        ['Rouge', 8],
        ['Noir', 9],
        ['Blanc', 10],
        ['Noir', 10],
        ['Argent', 11],
        ['Blanc', 12],
        ['Blanc', 13],
        ['Noir', 13],
        ['Noir', 14],
        ['Blanc', 14],
        ['Bleu marine', 15],
        ['Blanc', 15],
        ['Noir', 16],
        ['Bleu', 16],
        ['Jaune', 17],
        ['Blanc', 18],
        ['Bleu', 18],
        ['Blanc', 19],
        ['Noir', 19],
        ['Bleu', 20],
        ['Noir', 20]
    ];

    $stmt = $pdo->prepare("INSERT INTO colors (title_colors, product_id) VALUES (?, ?)");
    foreach ($colors as $color) {
        $stmt->execute($color);
    }
}

// Function to insert sizes
function insertSizes($pdo) {
    $sizes = [
        // Sizes for clothes
        ['S', 2],
        ['M', 2],
        ['L', 2],
        ['XL', 2],
        ['S', 7],
        ['M', 7],
        ['L', 7],
        ['XL', 7],
        ['S', 10],
        ['M', 10],
        ['L', 10],
        ['XL', 10],

        // Sizes for shoes
        ['38', 3],
        ['39', 3],
        ['40', 3],
        ['41', 3],
        ['42', 3],
        ['43', 3],
        ['44', 3],
        ['38', 8],
        ['39', 8],
        ['40', 8],
        ['41', 8],
        ['42', 8],
        ['43', 8],
        ['44', 8],
        ['38', 14],
        ['39', 14],
        ['40', 14],
        ['41', 14],
        ['42', 14],
        ['43', 14],
        ['44', 14],
        ['38', 18],
        ['39', 18],
        ['40', 18],
        ['41', 18],
        ['42', 18],
        ['43', 18],
        ['44', 18],

        // Sizes for gloves
        ['S', 4],
        ['M', 4],
        ['L', 4],
        ['S', 13],
        ['M', 13],
        ['L', 13]
    ];

    $stmt = $pdo->prepare("INSERT INTO size (title_size, product_id) VALUES (?, ?)");
    foreach ($sizes as $size) {
        $stmt->execute($size);
    }
}

// Function to insert sample orders
function insertOrders($pdo) {
    $orders = [
        ['En préparation', '2024-04-20 10:30:00', 129.98, 'Carte bancaire', '2024-04-25', 1, 1],
        ['Expédié', '2024-04-18 14:45:00', 239.97, 'PayPal', '2024-04-22', 2, 1],
        ['Livré', '2024-04-15 09:15:00', 89.99, 'Carte bancaire', '2024-04-19', 3, 1]
    ];

    $stmt = $pdo->prepare("INSERT INTO orders (statut, date_order, total_amount, mode_paiement, date_, address_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    foreach ($orders as $order) {
        $stmt->execute($order);
    }
}

// Function to insert order items (stocker table)
function insertStockerItems($pdo) {
    $items = [
        [1, 1], // Ballon de football dans la commande 1
        [2, 1], // Maillot équipe de France dans la commande 1
        [6, 2], // Ballon de basketball dans la commande 2
        [7, 2], // Maillot Lakers dans la commande 2
        [8, 2], // Chaussures de basketball dans la commande 2
        [16, 3] // Raquette de tennis dans la commande 3
    ];

    $stmt = $pdo->prepare("INSERT INTO stocker (product_id, order_id) VALUES (?, ?)");
    foreach ($items as $item) {
        $stmt->execute($item);
    }
}

// Function to insert product ratings (Evaluer table)
function insertRatings($pdo) {
    $ratings = [
        [1, 1, 4, '2024-04-10 17:30:00'], // User 1 rates product 1 with 4 stars
        [1, 6, 5, '2024-04-12 11:45:00'], // User 1 rates product 6 with 5 stars
        [1, 16, 5, '2024-04-14 14:20:00'] // User 1 rates product 16 with 5 stars
    ];

    $stmt = $pdo->prepare("INSERT INTO Evaluer (user_id, product_id, rating, date_rating) VALUES (?, ?, ?, ?)");
    foreach ($ratings as $rating) {
        $stmt->execute($rating);
    }
}

// Function to insert favorite products (aimer table)
function insertFavorites($pdo) {
    $favorites = [
        [1, 2], // User 1 likes product 2 (Maillot équipe de France)
        [1, 7], // User 1 likes product 7 (Maillot Lakers)
        [1, 11] // User 1 likes product 11 (Set de clubs de golf)
    ];

    $stmt = $pdo->prepare("INSERT INTO aimer (user_id, product_id) VALUES (?, ?)");
    foreach ($favorites as $favorite) {
        $stmt->execute($favorite);
    }
}

// Main function to populate the database
/** function populateDatabase($pdo) {
    try {
        // Create tables
        createTables($pdo);
        echo "Tables created successfully<br>";

        // Insert data
        insertUsers($pdo);
        echo "Users inserted successfully<br>";

        insertCategories($pdo);
        echo "Categories inserted successfully<br>";

        insertAddresses($pdo);
        echo "Addresses inserted successfully<br>";

        insertProducts($pdo);
        echo "Products inserted successfully<br>";

        insertPictures($pdo);
        echo "Pictures inserted successfully<br>";

        insertColors($pdo);
        echo "Colors inserted successfully<br>";

        insertSizes($pdo);
        echo "Sizes inserted successfully<br>";

        insertOrders($pdo);
        echo "Orders inserted successfully<br>";

        insertStockerItems($pdo);
        echo "Order items inserted successfully<br>";

        insertRatings($pdo);
        echo "Ratings inserted successfully<br>";

        insertFavorites($pdo);
        echo "Favorites inserted successfully<br>";

        echo "Database populated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Connect to the database and populate it
try {
    $pdo = new PDO("mysql:host=localhost", "root", "secret");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    populateDatabase($pdo);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
} **/


// Initialisation de la base de données
createTables($pdo);
insertUsers($pdo);
insertCategories($pdo);
insertAddresses($pdo);
insertProducts($pdo);
insertPictures($pdo);
insertColors($pdo);
insertSizes($pdo);
insertOrders($pdo);
insertStockerItems($pdo);
insertRatings($pdo);
insertFavorites($pdo);

echo "Base de données initialisée avec succès !";
