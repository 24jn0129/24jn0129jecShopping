<?php

require_once 'DAO.php';
require_once 'CartDAO.php';
require_once 'SaleDetailDAO.php';

class SaleDAO
{

    private function get_saleno()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT IDENT_CURRENT('Sale') AS saleno";

        $stmt = $dbh->query($sql);

        $row = $stmt->fetchObject();

        return $row->saleno;
    }

    public function insert(int $memberid, Array $cart_list)
    {
        $dbh = DAO::get_db_connect();

        $sql = "INSERT INTO Sale(saledate,memberid) VALUES(:saledate,:memberid)";

        $stmt = $dbh->prepare($sql);

        $saledate= date('Y-m-d H:i:s');

        $stmt->bindValue(':saledate', $saledate, PDO::PARAM_STR);
        $stmt->bindValue(':memberid', $memberid, PDO::PARAM_INT);

        $stmt->execute();

        $saleno = $this->get_saleno();

        $saleDetailDAO = new SaleDetailDAO();

        foreach($cart_list as $cart) {
            $saleDetail = new SaleDetail();

            $saleDetail->saleno = $saleno;
            $saleDetail->goodscode = $cart->goodscode;
            $saleDetail->num = $cart->num;

            $saleDetailDAO->insert($saleDetail,$dbh);
        }
    }
}
?>