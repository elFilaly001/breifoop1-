<?php
include_once "Connection.php";

class Offer
{
    private $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function showOffer()
    {
        $sql = "select * from offre";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            foreach ($results as $result) :
                $id = $result['OffreID'];
                $TitreOffre = $result['TitreOffre'];
                $DescriptionOffre = $result['DescriptionOffre'];
                $Company = $result['Company'];
                $Location = $result['Location'];
                $Statut = $result['Statut'];
                $Visibilite = $result['Visibilite'];
                $DatePublication = $result['DatePublication'];
                $Image = $result['Image']; ?>
                <form action="Post">
                    <article class="postcard light green">
                        <a class="postcard__img_link" href="#">
                            <input type="hidden" name="idoffer" value="<?= $id ?>">
                            <img class="postcard__img" src="../styles/img/<?= $Image ?>" alt="Image Title" />

                        </a>
                        <div class="postcard__text t-dark">
                            <h3 class="postcard__title green"><a href="#"><?= $TitreOffre ?></a></h3>
                            <div class="postcard__subtitle small">
                                <time datetime="2020-05-25 12:00:00">
                                    <i class="fas fa-calendar-alt mr-2"></i><?= $DatePublication ?>
                                </time>
                            </div>
                            <div class="postcard__bar"></div>
                            <div class="postcard__preview-txt">
                                <p><?= $DescriptionOffre ?></p>
                            </div>
                            <ul class="postcard__tagbox">
                                <li class="tag__item"><i class="fas fa-tag mr-2"></i><?= $Location ?></li>
                                <li class="tag__item play green">
                                    <a href="#"><i class="fas fa-play mr-2"></i>APPLY NOW</a>
                                </li>
                            </ul>
                        </div>
                    </article>
                </form>
            <?php

            endforeach;
        }
    }
    public function applytoOffer()
    {

        if (isset($_SESSION["userid"])) {
            $sql = "insert into candidature values (null ,? , ? ,'En attente' ,?, CURDATE())";
            $stmt = $this->conn->conn()->prepare($sql);
            // print_r($_SESSION);
            // print_r($_POST["idoffer"]);

            // die();
            $result = $stmt->execute([$_SESSION['userid'], $_POST['idoffer'], $_POST['title']]);
            if ($result === true) {
                header("Location: ../index.php");
                exit();
            } else {
                echo "Failed to apply for the offer.";
            }
        } else {
            header("Location: ../login.php");
        }
    }

    // public function checkoffre(){
    //     $sql = "select * from condcandidature"
    // }

    public function findOffer($keyword, $Company, $Location)
    {
        $sql = "select * from offre where TitreOffre like '%$keyword%' and Company like '%$Company%' and Location like '%$Location%'";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $result) : ?>
            <form method="post" action="classes/Offre.php">
                <article class="postcard light green">
                    <input type="hidden" name="idoffer" value="<?= $result['OffreID'] ?>">
                    <a class="postcard__img_link" href="#">
                        <img class="postcard__img" src="styles/img/<?= $result['Image'] ?>" alt="Image Title" />
                    </a>
                    <div class="postcard__text t-dark">
                        <input type="hidden" name="title" value="<?= $result['TitreOffre'] ?>">
                        <h3 class="postcard__title green"><?= $result['TitreOffre'] ?></h3>
                        <div class="postcard__subtitle small">
                            <time datetime="2020-05-25 12:00:00">
                                <i class="fas fa-calendar-alt mr-2"></i><?= $result['DatePublication'] ?>
                            </time>
                        </div>
                        <div class="postcard__bar"></div>
                        <div class="postcard__preview-txt"><?= $result['DescriptionOffre'] ?></div>
                        <ul class="postcard__tagbox">
                            <li class="tag__item"><i class="fas fa-tag mr-2"></i><?= $result['Location'] ?></li>
                            <li class="tag__item play green">
                                <button type="submit" class="btn btn-primary" name="apllyOffre"><i class="fas fa-play mr-2">APPLY NOW</a>
                            </li>
                        </ul>
                    </div>
                </article>
            </form>

<?php
        endforeach;
    }

    public function addOffer($Titre, $Descr, $Company, $Location, $img)
    {
        $sql = "insert into offre values (NUll , ? , ?, ? , ? ,' Actif', 'En attente' , CURDATE(), ? )";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute([$Titre, $Descr, $Company, $Location, $img]);
    }
}

$conn = new Connection();
$offer = new Offer($conn);

if (isset($_POST['keyword'])) {
    $offer->findOffer($_POST['keyword'], $_POST['Location'], $_POST['Company']);
}

if (isset($_POST['submitOffre'])) {
    $Titre = $_POST['Titre'];
    $Descr =  $_POST['Descrption'];
    $Company =  $_POST['Company'];
    $Location =  $_POST['Location'];
    extract($_POST);
    $image_name = $_FILES['jobImg']['name'];
    $image_temp = $_FILES['jobImg']['tmp_name'];
    $image_type = $_FILES['jobImg']['type'];
    $image_size = $_FILES['jobImg']['size'];
    $image_error = $_FILES['jobImg']['error'];
    $allowed = array('jpg', 'png', 'jif');
    $image = explode('.', $image_name);
    $image_ext = strtolower(end($image));
    if ($image_error == 4) {
        echo "file is not uploaded";
    } else if ($image_size) {
        if (in_array($image_ext, $allowed)) {
            $jobImage = uniqid() . $image_name;
            move_uploaded_file($image_temp, $_SERVER['DOCUMENT_ROOT'] . '/breifoop1-/jobease-php-oop-master/styles/img/' . $jobImage);
            $jobs = $offer->addOffer($Titre, $Descr, $Company, $Location, $jobImage);
            if ($jobs) {
                header('location:../views/dashboard/addOffer.php');
            }
        } else {
            echo "file is not valid you need this extention ('jpg' , 'png' , 'jfif')";
        }
    } else {
        echo "size to file is so heigh";
    }
}

if (isset($_POST['apllyOffre'])) {
    $offer->applytoOffer();
}
