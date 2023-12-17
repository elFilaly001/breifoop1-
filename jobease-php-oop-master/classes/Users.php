<?php
include_once "Connection.php";
$conn = new Connection();
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
        $sql = "SELECT * FROM utilisateur WHERE Email = ?";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($password, $result['MotDePasse'])) {
                $_SESSION['roleuser'] = $result['Role'];
                $_SESSION['userid'] = $result['UserID'];
                if ($result['Role'] == 'Candidat') {
                    header("Location: ../index.php");
                    die();
                } elseif ($result['Role'] == 'Admin') {
                    header("Location: ../dashboard/dashboard.php");
                    die();
                }
            } else {
                header("Location: ../login.php");
                die();
            }
        } else {
            header("Location: ../login.php");
            die();
        }
    }
    public function showAllCondidat()
    {
        $sql = "select * from utilisateur u Natural join candidature c where u.Role = 'Candidat' ";
        $stmt = $this->conn->conn()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $result) : ?>
            <tr class="freelancer">
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://mdbootstrap.com/img/new/avatars/7.jpg" class="rounded-circle" alt="" style="width: 45px; height: 45px" />
                        <div class="ms-3">
                            <p class="fw-bold mb-1 f_name"><?= $result['NomUtilisateur'] ?></p>
                            <p class="text-muted mb-0 f_email"><?= $result['Email'] ?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="fw-normal mb-1 f_title"><?= $result['Title'] ?></p>

                </td>
                <td>
                    <span class="f_status"><?= $result['StatutCand'] ?></span>
                </td>
                <td class="f_position"><?= $result['Position'] ?></td>
                <td>
                    <img class="delet_user" src="img/user-x.svg" alt="" name="delete<?= $result['UserID'] ?>">
                    <img class="ms-2 edit" src="img/edit.svg" alt="" name="update<?= $result['UserID'] ?>">
                </td>
            </tr>
<?php
        endforeach;
    }
}

if (isset($_POST['Register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password  = $_POST['password'];
    $confpassword = $_POST['confpassword'];

    $addUser = new Users($conn);

    if ($password == $confpassword) {
        $hashpass = password_hash($password, PASSWORD_DEFAULT);
        $addUser->RegisterUser($name, $hashpass, $email);
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
