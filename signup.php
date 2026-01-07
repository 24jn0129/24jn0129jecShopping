<?php
    require_once './helpers/MemberDAO.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $membername = $_POST['membername'];
        $zipcode = $_POST['zipcode'];
        $address =$_POST['address'];
        $tel1 = $_POST['tel1'];
        $tel2 = $_POST['tel2'];
        $tel3 = $_POST['tel3'];

        $memberDAO = new MemberDAO();

        if($email === ''){
            $errs['email'] = 'メールアドレスを入力してください。';
        }

        elseif($memberDAO->email_exists($email)){
            $errs['email'] = 'このメールアドレスはすでに登録されています';
        }

        if(!preg_match('/\A.{4,}\z/',$password)){
            $errs['password'] = 'パスワードは4文字以上で入力してください。';
        }

        elseif($password !== $password2){
            $errs['password'] = 'パスワードが一致しません。';
        }

        if(empty($membername)){
            $errs['membername'] = 'お名前を入力してください。';
        }

        if(!preg_match('/\A([0-9]{3})-([0-9]{4})\z/',$zipcode)){
            $errs['zipcode'] = '郵便番号は3桁-4桁で入力してください。';
        }

        if(empty($address)){
            $errs['address'] = '住所を入力してください。';
        }

        if(!preg_match('/\A(\d{2,5})?\z/',$tel1) || !preg_match('/\A(\d{1,4})?\z/',$tel2) || !preg_match('/\A(\d{4})?\z/',$tel3)){
            $errs['tel'] = '電話番号は半角数字２～５桁、１～４桁、４桁で入力してください。';
        }

        if(empty($errs)){
            $member = new member();
            $member->email = $email;
            $member->password = $password;
            $member->membername = $membername;
            $member->zipcode = $zipcode;
            $member->address = $address;

            $member->tel = '';
            if($tel1 !== '' && $tel2 !== '' && $tel3 !== ''){
                $member->tel ="{$tel1}-{$tel2}-{$tel3}";
            }

            $memberDAO->insert($member);

            header('Location: signupEnd.php');
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="uft-8" />
        <title>ログイン</title>
    </head>
    <body>
    <?php include "header2.php"; ?>

       <h1>会員登録</h1>
       <p>以下の項目を入力して、登録ボタンをクリックしてください（*は必須）</p>
      <form action="" method="POST">
      <table>
            <tr>
                <td>メールアドレス*</td>
                <td><input type="email" name="email" value="<?=  @$email ?>">
                <span style="color:red"><?= @$errs['email']?></span>
                </td>
            </tr>
            <tr>
                <td>パスワード(4文字以上)*</td>
                <td><input type="password" name="password" value="<?=  @$password ?>" pattern="\d{4,}" title="このテキストは４文字以上で指定してください（現在は３文字です）。">
                <span style="color:red"><?= @$errs['password']?></span>
                </td>
            </tr>
            <tr>
                <td>パスワード(再入力)*</td>
                <td><input type="password" name="password2" value="<?=  @$password2 ?>">
                </td>
            </tr>
            <tr>
                <td>お名前*</td>
                <td><input type="text" name="membername" value="<?=  @$membername ?>">
                <span style="color: red"><?= @$errs['membername']?></span>
                </td>
            </tr>
            <tr>
                <td>郵便番号*</td>
                <td><input type="text" name="zipcode" value="<?=  @$zipcode ?>" pattern="\d{3}-\d{4}" title="郵便番号は3桁-4桁で入力してください。">
                <span style="color: red"><?= @$errs['zipcode']?></span>
                </td>
            </tr>
            <tr>
                <td>住所*</td>
                <td><input type="text" name="address" value="<?=  @$address ?>">
                <span style="color: red"><?= @$errs['address']?></span>
                </td>
            </tr>
            <tr>
                <td>電話番号</td>
                <td>
                    <input type="tel" name="tel1" size="4" value="<?=  @$tel1 ?>"> ー
                    <input type="tel" name="tel2" size="4" value="<?=  @$tel2 ?>"> ー
                    <input type="tel" name="tel3" size="4" value="<?=  @$tel3 ?>">
                    <span style="color: red"><?= @$errs['tel']?></span>
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="登録する">
      </form> 
    </body>
</html>