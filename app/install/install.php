<?php
require_once '../includes/dbconnect.php';

// Fonction pour créer les tables
function createTables($pdo) {
    $queries = [
        "DROP DATABASE IF EXISTS clickandsport;",
        "CREATE DATABASE clickandsport;",
        "USE clickandsport;",
        "CREATE TABLE users (
            user_id INT AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            firstname VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone_number VARCHAR(20) NOT NULL,
            password VARCHAR(50) NOT NULL,
            PRIMARY KEY(user_id),
            UNIQUE(email),
            UNIQUE(password)
        )",

        "CREATE TABLE categories (
            categorie_id INT AUTO_INCREMENT,
            title_categorie VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            PRIMARY KEY(categorie_id)
        )",

        "CREATE TABLE address (
            address_id INT AUTO_INCREMENT,
            city VARCHAR(255) NOT NULL,
            zipcode CHAR(5) NOT NULL,
            type VARCHAR(50),
            address VARCHAR(255) NOT NULL,
            user_id INT NOT NULL,
            PRIMARY KEY(address_id),
            FOREIGN KEY(user_id) REFERENCES users(user_id)
        )",

        "CREATE TABLE colors (
            color_id VARCHAR(50),
            title_colors VARCHAR(100) NOT NULL,
            PRIMARY KEY(color_id)
        )",

        "CREATE TABLE size (
            size_id INT AUTO_INCREMENT,
            title_size VARCHAR(50),
            PRIMARY KEY(size_id)
        )",

        "CREATE TABLE products (
            product_id INT AUTO_INCREMENT,
            title_product VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            description TEXT NOT NULL,
            categorie_id INT NOT NULL,
            PRIMARY KEY(product_id),
            FOREIGN KEY(categorie_id) REFERENCES categories(categorie_id)
        )",

        "CREATE TABLE orders (
            order_id INT AUTO_INCREMENT,
            statut VARCHAR(50) NOT NULL,
            date_order DATETIME NOT NULL,
            total_amount DECIMAL(15,2),
            mode_paiement VARCHAR(50),
            date_ VARCHAR(50),
            address_id INT NOT NULL,
            user_id INT NOT NULL,
            PRIMARY KEY(order_id),
            FOREIGN KEY(address_id) REFERENCES address(address_id),
            FOREIGN KEY(user_id) REFERENCES users(user_id)
        )",

        "CREATE TABLE picture (
            picture_id INT AUTO_INCREMENT,
            title_picture VARCHAR(100) NOT NULL,
            product_id INT NOT NULL,
            PRIMARY KEY(picture_id),
            FOREIGN KEY(product_id) REFERENCES products(product_id)
        )",

        "CREATE TABLE stocker (
            product_id INT,
            order_id INT,
            PRIMARY KEY(product_id, order_id),
            FOREIGN KEY(product_id) REFERENCES products(product_id),
            FOREIGN KEY(order_id) REFERENCES orders(order_id)
        )",

        "CREATE TABLE Evaluer (
            user_id INT,
            product_id INT,
            rating TINYINT NOT NULL,
            date_rating DATETIME NOT NULL,
            PRIMARY KEY(user_id, product_id),
            FOREIGN KEY(user_id) REFERENCES users(user_id),
            FOREIGN KEY(product_id) REFERENCES products(product_id)
        )",

        "CREATE TABLE aimer (
            user_id INT,
            product_id INT,
            PRIMARY KEY(user_id, product_id),
            FOREIGN KEY(user_id) REFERENCES users(user_id),
            FOREIGN KEY(product_id) REFERENCES products(product_id)
        )",

        "CREATE TABLE decliner (
            product_id INT,
            color_id VARCHAR(50),
            size_id INT,
            stock_quantity TINYINT NOT NULL,
            PRIMARY KEY(product_id, color_id, size_id),
            FOREIGN KEY(product_id) REFERENCES products(product_id),
            FOREIGN KEY(color_id) REFERENCES colors(color_id),
            FOREIGN KEY(size_id) REFERENCES size(size_id)
        );"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
    }
}

// Fonction pour insérer des utilisateurs
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
        ['Golf', 'Articles de golf'],
        ['Tennis', 'Articles de tennis']
    ];

    $stmt = $pdo->prepare("INSERT INTO categories (title_categorie, description) VALUES (?, ?)");
    foreach ($categories as $category) {
        $stmt->execute($category);
    }
}

// Fonction pour insérer des adresses
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

// Fonction pour insérer des produits
function insertProducts($pdo) {
    $products = [
        // Football products (category_id = 1)
        ['Ballon de football professionnel', 39.99, 'Ballon de football officiel, taille 5, parfait pour les matchs et les entraînements.', 1],
        ['Maillot équipe de France', 89.99, 'Maillot officiel de l\'équipe de France, collection 2024.', 1],
        ['Chaussures de football à crampons', 119.99, 'Chaussures de football haute performance avec crampons pour terrain sec.', 1],
        ['Gants de gardien de but', 29.99, 'Gants professionnels avec protection optimale pour les gardiens de but.', 1],
        ['Protège-tibias', 19.99, 'Protège-tibias légers et résistants pour une protection optimale.', 1],

        // Basketball products (category_id = 2)
        ['Ballon de basketball NBA', 49.99, 'Ballon officiel NBA, taille 7, parfait pour la compétition.', 2],
        ['Maillot Los Angeles Lakers', 79.99, 'Maillot officiel des Lakers, saison 2024.', 2],
        ['Chaussures de basketball', 129.99, 'Chaussures haute performance avec amorti pour les joueurs de basketball.', 2],
        ['Panier de basketball portable', 199.99, 'Panier de basketball réglable en hauteur, idéal pour le jardin.', 2],
        ['Shorts de basketball', 39.99, 'Shorts respirants et confortables pour la pratique du basketball.', 2],

        // Golf products (category_id = 3)
        ['Set de clubs de golf débutant', 299.99, 'Ensemble complet de clubs pour débutants, incluant un sac.', 3],
        ['Balles de golf premium', 24.99, 'Pack de 12 balles de golf haute performance.', 3],
        ['Gant de golf homme', 19.99, 'Gant de golf en cuir véritable pour une meilleure prise.', 3],
        ['Chaussures de golf imperméables', 149.99, 'Chaussures de golf imperméables avec crampons soft.', 3],
        ['Casquette de golf', 29.99, 'Casquette légère et respirante pour le golf.', 3],

        // Tennis products (category_id = 4)
        ['Raquette de tennis professionnelle', 179.99, 'Raquette de tennis en graphite pour joueur confirmé.', 4],
        ['Balles de tennis', 14.99, 'Tube de 3 balles de tennis pour tous types de surface.', 4],
        ['Chaussures de tennis tout terrain', 109.99, 'Chaussures conçues pour tous types de courts de tennis.', 4],
        ['Poignet éponge', 7.99, 'Pack de 2 poignets éponge pour absorber la transpiration.', 4],
        ['Sac de tennis 6 raquettes', 69.99, 'Sac spacieux pouvant contenir jusqu\'à 6 raquettes et accessoires.', 4]
    ];

    $stmt = $pdo->prepare("INSERT INTO products (title_product, price, description, categorie_id) VALUES (?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute($product);
    }
}

// Fonction pour insérer des images
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

// Fonction pour insérer des couleurs
function insertColors($pdo) {
    $colors = [
        ['Blanc'],
        ['Noir'],
        ['Bleu'],
        ['Rouge'],
        ['Orange'],
        ['Jaune'],
        ['Violet'],
        ['Argent'],
        ['Bleu marine']
    ];

    $stmt = $pdo->prepare("INSERT INTO colors (color_id, title_colors) VALUES (?, ?)");
    foreach ($colors as $index => $color) {
        $stmt->execute([strtolower($color[0]), $color[0]]);
    }
}

// Fonction pour insérer des tailles
function insertSizes($pdo) {
    $sizes = [
        ['S'],
        ['M'],
        ['L'],
        ['XL'],
        ['38'],
        ['39'],
        ['40'],
        ['41'],
        ['42'],
        ['43'],
        ['44']
    ];

    $stmt = $pdo->prepare("INSERT INTO size (title_size) VALUES (?)");
    foreach ($sizes as $size) {
        $stmt->execute($size);
    }
}

// Fonction pour insérer des déclinaisons de produits
function insertDecliner($pdo) {
    $decliner = [
        [1, 'blanc', 1, 10],
        [1, 'noir', 1, 10],
        [2, 'bleu', 1, 10],
        [2, 'blanc', 1, 10],
        [2, 'rouge', 1, 10],
        [3, 'noir', 1, 10],
        [3, 'bleu', 1, 10],
        [3, 'rouge', 1, 10],
        [4, 'noir', 1, 10],
        [4, 'blanc', 1, 10],
        [5, 'noir', 1, 10],
        [6, 'orange', 1, 10],
        [7, 'jaune', 1, 10],
        [7, 'violet', 1, 10],
        [8, 'blanc', 1, 10],
        [8, 'noir', 1, 10],
        [8, 'rouge', 1, 10],
        [9, 'noir', 1, 10],
        [10, 'blanc', 1, 10],
        [10, 'noir', 1, 10],
        [11, 'argent', 1, 10],
        [12, 'blanc', 1, 10],
        [13, 'blanc', 1, 10],
        [13, 'noir', 1, 10],
        [14, 'noir', 1, 10],
        [14, 'blanc', 1, 10],
        [15, 'bleu marine', 1, 10],
        [15, 'blanc', 1, 10],
        [16, 'noir', 1, 10],
        [16, 'bleu', 1, 10],
        [17, 'jaune', 1, 10],
        [18, 'blanc', 1, 10],
        [18, 'bleu', 1, 10],
        [19, 'blanc', 1, 10],
        [19, 'noir', 1, 10],
        [20, 'bleu', 1, 10],
        [20, 'noir', 1, 10]
    ];

    $stmt = $pdo->prepare("INSERT INTO decliner (product_id, color_id, size_id, stock_quantity) VALUES (?, ?, ?, ?)");
    foreach ($decliner as $item) {
        $stmt->execute($item);
    }
}

// Fonction pour insérer des commandes
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

// Fonction pour insérer des articles de commande (table stocker)
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

// Fonction pour insérer des évaluations de produits (table Evaluer)
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

// Fonction pour insérer des produits favoris (table aimer)
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

// Initialisation de la base de données
try {
    createTables($pdo);
    insertUsers($pdo);
    insertCategories($pdo);
    insertAddresses($pdo);
    insertProducts($pdo);
    insertPictures($pdo);
    insertColors($pdo);
    insertSizes($pdo);
    insertDecliner($pdo);
    insertOrders($pdo);
    insertStockerItems($pdo);
    insertRatings($pdo);
    insertFavorites($pdo);

    echo "Base de données initialisée avec succès !";
} catch (PDOException $e) {
    echo "Erreur lors de l'initialisation de la base de données : " . $e->getMessage();
}
?>
