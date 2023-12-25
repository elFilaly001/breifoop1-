<?php

namespace App\Controllers;


use App\Models\Database;
use App\Models\OffreModel;
use PDOException;

class offreController
{
    private $db;


    public function __construct()
    {
        // Get an instance of the Database class
        $this->db = Database::getInstance()->getConnection();
    }


    public function post_addOffre()
    {

        try {
            $job = new OffreModel($this->db);
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
                        move_uploaded_file($image_temp, $_SERVER['DOCUMENT_ROOT'] . '/assets/styles/img/' . $jobImage);
                        $jobs = $job->addOffer($Titre, $Descr, $Company, $Location, $jobImage);
                        if ($jobs) {

                            header('Location: ?route=addOffer');
                        }
                    } else {
                        echo "file is not valid you need this extention ('jpg' , 'png' , 'jfif')";
                    }
                } else {
                    echo "size to file is too heigh to upload";
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function showOffres()
    {
        $all = new OffreModel();
        if (isset($_POST['keyword'])) {
            $results = $all->findOffer($_POST['keyword'], $_POST['Company'], $_POST['Location']);

            foreach ($results as $result) :
?>
                <form method="post" action="?route=apply">
                    <article class="postcard light green">
                        <input type="hidden" name="idoffer" value="<?= $result['job_id'] ?>">
                        <a class="postcard__img_link" href="#">
                            <img class="postcard__img" src="assets/styles/img/<?= $result['image_path'] ?>" alt="Image Title" />
                        </a>
                        <div class="postcard__text t-dark">
                            <input type="hidden" name="title" value="<?= $result['title'] ?>">
                            <h3 class="postcard__title green"><?= $result['title'] ?></h3>
                            <div class="postcard__subtitle small">
                                <time datetime="2020-05-25 12:00:00">
                                    <i class="fas fa-calendar-alt mr-2"></i><?= $result['date_created'] ?>
                                </time>
                            </div>
                            <div class="postcard__bar"></div>
                            <div class="postcard__preview-txt"><?= $result['description'] ?></div>
                            <div class="postcard__preview-txt"><?= $result['company'] ?></div>
                            <ul class="postcard__tagbox">
                                <li class="tag__item"><i class="fas fa-tag mr-2"></i><?= $result['location'] ?></li>
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
    }

    public function applyToOffer()
    {
        $idJob = $_POST['idoffer'];
        $idUser = $_SESSION['userid'];

        if (!isset($_SESSION["roleuser"])) {
            header("Location: ?route=login");
        } elseif ($_SESSION["roleuser"] === "Candidat") {
            $aply = new OffreModel();
            $aply->applyToOffer($idUser, $idJob);
            header("Location: ?route=home");
        } else {
            header("Location: ?route=home");
        }
    }

    public function showOffresTB()
    {
        $jobs = new OffreModel();
        $results = $jobs->allOffres();
        foreach ($results as $result) :
            ?>
            <tr class="freelancer">
                <td>
                    <img src="assets/styles/img/<?= $result['image_path'] ?>" class="rounded-circle" alt="" style="width: 45px; height: 45px">
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="ms-3">
                            <p class="fw-bold mb-1 f_name"><?= $result['title'] ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1 f_title"><?= $result['description'] ?>.</p>

                </td>
                <td>
                    <p class="fw-normal mb-1 f_title"><?= $result['company'] ?></p>
                </td>
                <td class="f_position"><?= $result['location'] ?></td>
                <td class="f_position"><?= $result['date_created'] ?></td>
                <td class="f_position"><?= $result['status'] ?></td>
                <td class="">
                    <form action="?route=opORcl" method="post">
                        <input type="hidden" name="job_id" value="<?= $result['job_id'] ?>">
                        <button type="submit" class="btn btn-success" name="open" value="open">
                            <i class="fa-solid fa-check"></i>
                        </button>
                        <button type="submit" class="btn btn-danger" name="xmark" value="closed">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </td>
            </tr>


            <?php
        endforeach;
    }

    public function opORcl()
    {
        $job = $_POST['job_id'];
        $opncl = new OffreModel();
        if (isset($_POST['open']) or  isset($_POST['xmark'])) {
            if (isset($_POST['open'])) {
                $opncl->controlOffre($_POST['open'], $job);
                header("Location: ?route=offre");
            } elseif (isset($_POST['xmark'])) {
                $opncl->controlOffre($_POST['xmark'], $job);
                header("Location: ?route=offre");
            }
        }
    }

    public function showAllusers()
    {
        $users = new OffreModel;
        $results = $users->all_users();
        foreach ($results as $result) :
            if ($result["app_status"] === "in progress") :
            ?>
                <tr>
                    <td>
                        <?= $result['username'] ?>
                    </td>
                    <td>
                        <?= $result['title'] ?>
                    </td>
                    <td>
                        <?= $result['description'] ?>
                    </td>
                    <td> <?= $result['app_status'] ?></td>
                    <td>
                        <form action="?route=accOffre" method="post">
                            <input type="hidden" name="app_id" value="<?= $result['app_id'] ?>">
                            <button type="submit" class="btn btn-success " name="check" value="approved">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button type="submit" class="btn btn-danger" name="xmark" value="not approved">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
            else :
            ?>
                <tr class="freelancer">
                    <td>

                        <?= $result['username'] ?>

                    </td>
                    <td>
                        <?= $result['title'] ?>
                    </td>
                    <td>
                        <?= $result['description'] ?>

                    </td>
                    <td> <?= $result['app_status'] ?></td>
                </tr>
<?php
            endif;
        endforeach;
    }

    public function accOffre()
    {
        $job = $_POST['app_id'];
        $opncl = new OffreModel();
        if (isset($_POST['check']) or  isset($_POST['xmark'])) {
            if (isset($_POST['check'])) {
                $opncl->controlApp($_POST['check'], $job);
                header("Location: ?route=candidat");
            } elseif (isset($_POST['xmark'])) {
                $opncl->controlApp($_POST['xmark'], $job);
                header("Location: ?route=candidat");
            }
        }
    }
}
