<?php
include_once "Connection.php";
class Users
{
    //milk as a product
    private $conn;
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }
    public function RegisterUser($username, $password, $email)
    {
        $sql = "insert into utilisateur values (NULL ,  ? , ? , ? , 'Candidat')";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute([$username, $password, $email]);
    }

    public function Login($email, $password)
    {
        $sql = "select * from utilisateur where Email = ? and MotDePasse = ?";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute([$email, $password]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
            if ($result['Role'] == 'Candidat') {
                header("Location: ../index.php");
                die();
            } elseif ($result['Role'] == 'Admin') {
                header("Location: ../dashboard/dashboard.php");
                die();
            }
        }
    }

    public function showAllCondida()
    {
        $sql = "select * from utilisateur u Natural join candidateur where Role = 'Candidat' ";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) : ?>
            <tr class="freelancer">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1 f_name"><?= $result['NomUtilisateur'] ?></p>
                            <p class="text-muted mb-0 f_email"><?= $result['Email'] ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1 f_title">Software engineer <br> IT department</p>

                </td>
                <td>
                    <span class="f_status">Active</span>
                </td>
                <td class="f_position">Senior</td>
                <td>
                    <img class="delet_user" src="img/user-x.svg" alt="">
                    <img class="ms-2 edit" src="img/edit.svg" alt="">
                </td>
            </tr>
<?php
        endforeach;
    }
}
session_start();
$conn = new Connection();

if (isset($_POST['Register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password  = $_POST['password'];
    $confpassword = $_POST['confpassword'];

    $addUser = new Users($conn);

    if ($password == $confpassword) {
        $addUser->RegisterUser($name, $password, $email);
    }

    header("Location: ../login.php");
}
if (isset($_POST['Login'])) {

    $email = $_POST['email'];
    $password  = $_POST['password'];

    $addUser = new Users($conn);
    $_SESSION['useremail'] = $email;
    $addUser->Login($email, $password);
}
