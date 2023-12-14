<?php
include_once "Connection.php";
session_start();

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
                <article class="postcard light green">
                    <a class="postcard__img_link" href="#">
                        <input type="hidden" name="<?= $id ?>" value="<?= $id ?>">
                        <img class="postcard__img" src="https://picsum.photos/300/300" alt="Image Title" />

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
                                <a href="#"><i class="fas fa-play mr-2" name=></i>APPLY NOW</a>
                            </li>
                        </ul>
                    </div>
                </article>

<?php

            endforeach;
        }
    }
    public function applytoOffer()
    {
    }
}
