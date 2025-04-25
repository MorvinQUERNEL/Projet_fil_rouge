<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet fil Rouge</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>

<body>
    <header>
        <nav class="navigation">
            <div class="burger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            <div class="img">
                <img src="images/logo1.png" width="50" alt="logo">
            </div>
            <div class="icons">
                <svg id="panier" width="35" height="36" viewBox="0 0 35 36" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.45898 1.54175H7.29232L11.2007 22.1847C11.334 22.8944 11.6993 23.532 12.2325 23.9858C12.7657 24.4396 13.4329 24.6806 14.1173 24.6667H28.2923C28.9767 24.6806 29.6439 24.4396 30.1772 23.9858C30.7104 23.532 31.0756 22.8944 31.209 22.1847L33.5423 9.25008H8.75065M14.584 32.3751C14.584 33.2265 13.9311 33.9167 13.1257 33.9167C12.3202 33.9167 11.6673 33.2265 11.6673 32.3751C11.6673 31.5236 12.3202 30.8334 13.1257 30.8334C13.9311 30.8334 14.584 31.5236 14.584 32.3751ZM30.6257 32.3751C30.6257 33.2265 29.9727 33.9167 29.1673 33.9167C28.3619 33.9167 27.709 33.2265 27.709 32.3751C27.709 31.5236 28.3619 30.8334 29.1673 30.8334C29.9727 30.8334 30.6257 31.5236 30.6257 32.3751Z"
                        stroke="#5DE496" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg id="home" width="51" height="51" viewBox="0 0 51 51" fill="none">
                    <path
                        d="M25.5 25.5C23.1625 25.5 21.1615 24.6677 19.4969 23.0031C17.8323 21.3385 17 19.3375 17 17C17 14.6625 17.8323 12.6615 19.4969 10.9969C21.1615 9.33229 23.1625 8.5 25.5 8.5C27.8375 8.5 29.8385 9.33229 31.5031 10.9969C33.1677 12.6615 34 14.6625 34 17C34 19.3375 33.1677 21.3385 31.5031 23.0031C29.8385 24.6677 27.8375 25.5 25.5 25.5ZM8.5 42.5V36.55C8.5 35.3458 8.8099 34.2391 9.42969 33.2297C10.0495 32.2203 10.8729 31.45 11.9 30.9188C14.0958 29.8208 16.3271 28.9974 18.5938 28.4484C20.8604 27.8995 23.1625 27.625 25.5 27.625C27.8375 27.625 30.1396 27.8995 32.4062 28.4484C34.6729 28.9974 36.9042 29.8208 39.1 30.9188C40.1271 31.45 40.9505 32.2203 41.5703 33.2297C42.1901 34.2391 42.5 35.3458 42.5 36.55V42.5H8.5ZM12.75 38.25H38.25V36.55C38.25 36.1604 38.1526 35.8062 37.9578 35.4875C37.763 35.1687 37.5063 34.9208 37.1875 34.7438C35.275 33.7875 33.3448 33.0703 31.3969 32.5922C29.449 32.1141 27.4833 31.875 25.5 31.875C23.5167 31.875 21.551 32.1141 19.6031 32.5922C17.6552 33.0703 15.725 33.7875 13.8125 34.7438C13.4938 34.9208 13.237 35.1687 13.0422 35.4875C12.8474 35.8062 12.75 36.1604 12.75 36.55V38.25ZM25.5 21.25C26.6688 21.25 27.6693 20.8339 28.5016 20.0016C29.3339 19.1693 29.75 18.1687 29.75 17C29.75 15.8313 29.3339 14.8307 28.5016 13.9984C27.6693 13.1661 26.6688 12.75 25.5 12.75C24.3313 12.75 23.3307 13.1661 22.4984 13.9984C21.6661 14.8307 21.25 15.8313 21.25 17C21.25 18.1687 21.6661 19.1693 22.4984 20.0016C23.3307 20.8339 24.3313 21.25 25.5 21.25Z"
                        fill="#5DE496" />
                </svg>
            </div>
            <div class ="search-bar">
                <input type="text">
            </div>

        </nav>
    </header>
    <main>
        <div id="accueil">
            <h1>
                Click & Sport tout vos equipements et meteriels
            </h1>
        </div>
        <section id="section-categorie">
            <h2>CATEGORIES</h2>
            <div id="categories">
                <figure>
                    <img src="images/Football.png" alt="FOOTBALL">
                    <figcaption>FOOTBALL</figcaption>
                </figure>
                <figure>
                    <img src="images/Basketball.png" alt="BASKETBALL">
                    <figcaption>BASKETBALL</figcaption>
                </figure>
                <figure>
                    <img src="images/Golf.png" alt="GOLF">
                    <figcaption>GOLF</figcaption>
                </figure>
                <figure>
                    <img src="images/Tennis.png" alt="TENNIS">
                    <figcaption>TENNIS</figcaption>
                </figure>
            </div>
        </section>
        <section id="section-articles">
            <h2>ARTICLES DU MOMENT</h2>
            <div id="articles">
                <article>
                    <div>
                        <img src="images/balon_bascket.png" alt="balon bascket">
                    </div>
                    <div class="commentaire-acticle">
                        <h3>
                            Balon de Bascket
                        </h3>
                        <p>Coloris: Orange et noir</p>
                        <p>⭐️⭐️⭐️⭐️⭐️</p>
                        <p class="prix">9,99</p>
                    </div>

                </article>
                <article>
                    <div>
                        <img src="images/balon_football.png" alt="balon football">
                    </div>
                    <div class="commentaire-acticle">
                        <h3>
                            Balon de Bascket
                        </h3>
                        <p>Coloris: Orange et noir</p>
                        <p>⭐️⭐️⭐️⭐️⭐️</p>
                        <p class="prix">9,99</p>
                    </div>

                </article>
                <article>
                    <div>
                        <img src="images/chaussure.png" alt="chaussure">
                    </div>
                    <div class="commentaire-acticle">
                        <h3>
                            Balon de Bascket
                        </h3>
                        <p>Coloris: Orange et noir</p>
                        <p>⭐️⭐️⭐️⭐️⭐️</p>
                        <p class="prix">9,99</p>
                    </div>
                </article>
            </div>
        </section>
    </main>
    <footer>
        <h2>Suivez-nous</h2>
        <div>
            <img src="images/fb.png" alt="facebook">
            <img src="images/insta.png" alt="insta">
            <img src="images/snap.png" alt="snap">
        </div>
    </footer>
</body>
</html>