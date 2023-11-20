<?php
session_start();
error_reporting(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home | Book Reader</title>
    <link rel="shortcut icon" href="assets/img/book-outline.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="bar">
        <h2>BOOK READER</h2>
    </div>

    <div class="main-container">
        <!--ALL BOOKS CONTAINER BEGINS -->

        <div class="all-books container">
            <h1 class="heading">All Books
                <hr>
            </h1>


            <br><br>
            <div class="gal">
                <?php
                ini_set('display_errors', 1);
                error_reporting(E_ALL);
                # write sql query to get books, author, category
                $sql = "SELECT tblbooks.*, tblauthors.AuthorName from tblbooks join tblauthors on tblauthors.id=tblbooks.AuthorId";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $returnedbooks = $query->rowCount();
                # print each book in list format
                foreach ($results as $result) {
                    echo '<div class="gallery-item">';
                    echo '<a href="view-book.php?bookid=' . ($result->id) . '" class="out"><div class="outbox">';
                    echo '<img src="admin/bookimg/' . ($result->bookImage) . '" alt="">';
                    echo '<h3>' . htmlentities($result->BookName) . '</h3>';
                    echo '<p>' . htmlentities($result->AuthorName) . '</p>';
                    echo '<div class="icon"><button class="add-to-shelf"><ion-icon name="bookmark-outline" style="color: var(--newt);--ionicon-stroke-width: 30px;font-size: 18px;"></ion-icon></button></div>';
                    echo '</div></a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <!--ALL BOOKS CONTAINER END -->

        <!-- PRINTING ACTUAL LIST FROM THIS DIV -->
        <div class="gallery container" style="display:none;">
            <!-- Total Books Issued: -->
            <?php //echo htmlentities($returnedbooks); ?>
            <h1 class="heading">My Shelf
                <hr>
            </h1>


            <br><br>

            <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            $sid = $_SESSION['stdid'];
            $sql2 = "SELECT id, BookId from tblissuedbookdetails where StudentID=:sid";
            $query2 = $dbh->prepare($sql2);
            $query2->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query2->execute();
            $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
            $returnedbooks = $query2->rowCount();
            $returnedbooks;
            ?>


            <?php if ($returnedbooks == 0) { ?>
                Please add some books.
            <?php } ?>

            <?php if ($returnedbooks > 0) { ?>
                <div class="gallery">
                    <!-- loop over the books -->
                    <?php foreach ($results2 as $result) {
                        $bookid = $result->BookId;
                        $sql3 = "SELECT tblbooks.*, tblauthors.AuthorName FROM tblbooks JOIN tblauthors ON tblbooks.AuthorId = tblauthors.id WHERE tblbooks.id=:bookid";
                        $query3 = $dbh->prepare($sql3);
                        $query3->bindParam(':bookid', $bookid, PDO::PARAM_STR);
                        $query3->execute();
                        $results3 = $query3->fetchAll(PDO::FETCH_OBJ);
                        $bookid = $result->BookId;
                        ?>
                        <!-- print book details in list format -->
                        <?php foreach ($results3 as $result3) {
                            echo '<div class="gallery-item">';
                            echo '<a href="view-book.php?bookid=' . $bookid . '"><div class="outbox">';
                            echo '<img src="admin/bookimg/' . ($result3->bookImage) . '" alt="">';
                            echo '<h3>' . htmlentities($result3->BookName) . '</h3>';
                            echo '<p>' . htmlentities($result3->AuthorName) . '</p>';
                            echo "</div></a>";
                            echo '</div>'; ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <!-- GALLERY CONTAINER END -->

        <!-- ABOUT CONTAINER BEGINS -->
        <div class="about container" style="display:none;">
            <h1 class="heading">About
                <hr>
            </h1>
            <div class="about-para">
                <h1>Introducing RareBooksSite: A Gateway to Unveil a Treasure Trove of Knowledge</h1>
                <p>Welcome to RareBooksSite, your portal to an unparalleled repository of intellectual gems! We are
                    thrilled to present a revolutionary platform dedicated to the dissemination of rare and
                    invaluable
                    books that were once hidden from the world. In collaboration with the BMCC Library, we take
                    immense
                    pride in bridging the gap between academia and the public by offering two distinctive avenues to
                    access this precious knowledge.</p>

                <h2>Embarking on a Journey of Discovery</h2>
                <p>At RareBooksSite, we have meticulously curated and digitized a collection of 400 rare books, a
                    treasure trove of wisdom spanning various subjects and disciplines. This carefully preserved
                    wealth
                    of knowledge, available exclusively on our platform, holds the potential to inspire and enrich
                    the
                    minds of academicians, students, research scholars, and enthusiasts alike.</p>

                <h2>Empowering Scholars and Enthusiasts</h2>
                <p>We recognize the significance of fostering an inclusive and accessible platform that caters to
                    the
                    diverse needs of our users. As such, we present two distinctive pathways for you to embark on
                    your
                    journey of discovery:</p>
                <ol>
                    <li><strong>Virtual Library:</strong> Immerse yourself in the enchanting world of rare books
                        through
                        our digital library. Experience the convenience of accessing these invaluable resources from
                        the
                        comfort of your home or academic institution. Our user-friendly interface allows seamless
                        browsing and reading, making sure you can focus on what truly matters unraveling the depths
                        of
                        knowledge encapsulated within these rare tomes.</li>
                    <li><strong>Interactive Community:</strong> Engage, collaborate, and contribute to an
                        ever-growing
                        community of scholars and enthusiasts on our website. We encourage users to share their
                        insights, reviews, and discussions related to these rare books. Exchange ideas, connect with
                        like-minded individuals, and foster intellectual discourse on a global scale.</li>
                </ol>

                <h2>Unparalleled Accessibility</h2>
                <p>Our mission is to eliminate barriers that separate knowledge from those who seek it. We have
                    meticulously designed RareBooksSite to be accessible to a broad spectrum of users, irrespective
                    of
                    geographical boundaries or financial constraints. The platform is open to all, fostering a
                    spirit of
                    inclusivity and democratizing access to rare literary treasures.</p>

                <h2>Preserving Our Cultural Heritage</h2>
                <p>RareBooksSite is not just a website; it's a passion-driven initiative to safeguard the
                    intellectual
                    heritage of humanity. We understand the irreplaceable value of these rare books and the
                    knowledge
                    they encapsulate. With our advanced digital preservation techniques, we ensure that this
                    treasure
                    remains accessible to future generations, safeguarding the collective wisdom of the past for the
                    betterment of the future.</p>

                <h2>Join the RareBooksSite Community</h2>
                <p>We extend our warmest invitation to you the curious minds, the avid learners, the passionate
                    researchers to join us on this extraordinary journey of exploration and enlightenment. Together,
                    we
                    will celebrate the past, embrace the present, and shape the future through the power of
                    knowledge.
                </p>

                <p>Come, be a part of RareBooksSite, where the past meets the present, and the quest for knowledge
                    knows
                    no boundaries. Start your journey today and unlock the secrets of our shared intellectual
                    legacy.
                </p>

                <p><em>Unveiling a world of rare wisdom RareBooksSite.</em></p>
            </div>
        </div>
        <!-- ABOUT CONTAINER END -->

        <!-- FAQ CONTAINER BEGINS -->
        <div class="faq container" style="display:none;">
            <h1 class="heading">FAQ's
                <hr>
            </h1>
            <div class="faq-content">
                <div class="faq-question">
                    <input id="q1" type="checkbox" class="panel">
                    <label for="q1" class="panel-title">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Tempora consequuntur totam illum iste sequi esse dolorum minima pariatur eos!</label>
                    <div class="panel-content">Lorem ipsum dolor sit amet consectetur.</div>
                </div>

                <div class="faq-question">
                    <input id="q2" type="checkbox" class="panel">
                    <label for="q2" class="panel-title">Lorem ipsum dolor sit amet consectetur</label>
                    <div class="panel-content">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloribus,
                        delectus!</div>
                </div>

                <div class="faq-question">
                    <input id="q3" type="checkbox" class="panel">
                    <label for="q3" class="panel-title">Lorem ipsum dolor sit amet consectetur adipisicing?</label>
                    <div class="panel-content">Certain questions are better left &nbsp; <a
                            href="https://en.wikipedia.org/wiki/The_Unanswered_Question" target="_blank">unanswered</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- FAQ CONTAINER END -->

        <!--Privacy Policy CONTAINER BEGINS -->
        <div class="privacy-policy container" style="display:none;">
            <h1 class="heading">Privacy Policy
                <hr>
            </h1>
            <div class="about-para">
                <p>Last Updated: [Date]</p>
                <p>Thank you for using [Your Web App Name] ("we," "us," "our," or "[Web App Name]"). We are
                    committed to
                    protecting your privacy and safeguarding the personal information you provide to us while using
                    our
                    web application. This Privacy Policy outlines how we collect, use, disclose, and protect your
                    information when you interact with [Web App Name]. By using our web app, you agree to the terms
                    and
                    practices described in this Privacy Policy.</p>

                <h2>Information We Collect</h2>
                <p>We may collect various types of information from you while you use [Web App Name]:</p>
                <ol>
                    <li><strong>Personal Information:</strong> When you sign up for an account or use certain
                        features
                        of the web app, we may collect personally identifiable information such as your name, email
                        address, contact details, and other information you voluntarily provide.</li>
                    <li><strong>Usage Data:</strong> We collect information about your interactions with the web
                        app,
                        including your IP address, browser type, device information, pages visited, and actions
                        performed on the app.</li>
                </ol>

                <h2>How We Use Your Information</h2>
                <p>We use the collected information for the following purposes:</p>
                <ul>
                    <li><strong>Providing and Improving Services:</strong> To deliver personalized content and
                        services,
                        enhance user experience, and continuously improve our web app's functionality and features.
                    </li>
                    <li><strong>Communication:</strong> To respond to your inquiries, provide customer support, and
                        send
                        you updates, notifications, and promotional materials related to [Web App Name]. You can
                        opt-out
                        of receiving marketing emails by following the unsubscribe instructions provided in the
                        email.
                    </li>
                    <li><strong>Security:</strong> To protect our web app, prevent fraud, and ensure the security
                        and
                        integrity of our systems and user accounts.</li>
                    <li><strong>Legal Compliance:</strong> To comply with applicable laws, regulations, and legal
                        processes.</li>
                </ul>

                <h2>Information Sharing and Disclosure</h2>
                <p>We do not sell, trade, or rent your personal information to third parties. However, we may share
                    your
                    information in the following circumstances:</p>
                <ul>
                    <li><strong>Service Providers:</strong> We may engage third-party service providers to assist us
                        in
                        operating the web app and providing our services. These service providers may have access to
                        your personal information but are obligated to maintain its confidentiality and use it only
                        for
                        the purposes of providing services to us.</li>
                    <li><strong>Legal Requirements:</strong> We may disclose your information if required to do so
                        by
                        law, or in good faith belief that such action is necessary to comply with legal obligations,
                        protect our rights or property, or investigate potential violations.</li>
                </ul>

                <h2>Data Security</h2>
                <p>We take the security of your information seriously and employ reasonable measures to protect it
                    from
                    unauthorized access, disclosure, alteration, or destruction. However, no method of data
                    transmission
                    over the internet or electronic storage is 100% secure. While we strive to use commercially
                    acceptable means to protect your personal information, we cannot guarantee its absolute
                    security.
                </p>

                <h2>Children's Privacy</h2>
                <p>[Web App Name] is not intended for use by individuals under the age of 13. We do not knowingly
                    collect personal information from children under 13. If you believe we have inadvertently
                    collected
                    such information, please contact us, and we will promptly take appropriate actions to delete it
                    from
                    our records.</p>

                <h2>Changes to this Privacy Policy</h2>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices or for
                    other
                    operational, legal, or regulatory reasons. The revised Privacy Policy will be effective
                    immediately
                    upon posting on this page. Please review this page periodically to stay informed about our
                    information practices.</p>

                <h2>Contact Us</h2>
                <p>If you have any questions, concerns, or requests related to this Privacy Policy or your personal
                    information, please contact us at [contact email or address].</p>

                <p>By using [Web App Name], you agree to this Privacy Policy and our Terms of Service. Thank you for
                    trusting us with your information.</p>
            </div>
        </div>
        <!--Privacy Policy CONTAINER END -->

        <!--Privacy Policy CONTAINER BEGINS -->
        <div class="terms-of-service container" style="display:none;">
            <h1 class="heading">Terms of Service
                <hr>
            </h1>
        </div>
        <!--Privacy Policy CONTAINER END -->

        <!-- Footer -->
        <footer>
            <div class="footer">
                <div class="row">
                    <a href="https://www.facebook.com/BMCCautonomous"><ion-icon name="logo-facebook"
                            size="large"></ion-icon></a>
                    <a href="https://www.instagram.com/bmcc_autonomous/"><ion-icon name="logo-instagram"
                            size="large"></ion-icon></a>
                </div>

                <div class="row">
                    <ul>
                        <li><a onclick="showContainer('about')">About</a></li>
                        <li><a onclick="showContainer('privacy-policy')">Privacy Policy</a></li>
                        <li><a onclick="showContainer('terms-of-service')">Terms of Service</a></li>
                        <li><a href="https://bmcc.ac.in" target="_blank">College Website</a></li>

                    </ul>
                </div>

                <div class="row">
                    Copyright © 2023 Brihan Maharashtra College of Commerce
                </div>
            </div>
        </footer>

    </div>
    <!--RIGHT SIDE CONTENT END-->

    </section>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type="text/javascript">
        const toggleSidebar = () => document.body.classList.toggle("open");
    </script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    </div>
</body>

<script>
    function showContainer(containerName) {
        // Get all containers
        const containers = document.querySelectorAll('.container');

        // Get all buttons
        const buttons = document.querySelectorAll('button');

        // Remove active class from all buttons
        buttons.forEach(button => {
            button.classList.remove('active-button');
        });

        // Hide all containers
        containers.forEach(container => {
            container.style.display = 'none';
        });

        // Show the container with the given name
        const containerToShow = document.querySelector('.' + containerName);
        containerToShow.style.display = 'block';

        // Highlight the active button
        const activeButton = document.querySelector('.' + containerName + '-button');
        activeButton.classList.add('active-button');
    }
    // Add a class to the default button when the page loads
    window.addEventListener('load', function () {
        const defaultContainerName = 'default-container'; // Change this to your default container class name
        const defaultButton = document.querySelector('.' + defaultContainerName + '-button');
        defaultButton.classList.add('active-button');
    });

    // Call showContainer with the default container name when the page loads
    window.addEventListener('load', function () {
        const defaultContainerName = 'all-books'; // Change this to your default container class name
        showContainer(defaultContainerName);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const logoutButton = document.getElementById('logoutButton');

        logoutButton.addEventListener('click', function () {
            Swal.fire({
                title: 'Confirm Logout',
                text: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php';
                }
            });
        });
    });
</script>

</html>