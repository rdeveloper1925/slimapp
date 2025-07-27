<?php
namespace App\Repositories;

use App\Interfaces\DatabaseInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class UserRepo{
    private DatabaseInterface $db;
    private Connection $conn;
    private QueryBuilder $qb;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->conn = $this->db->getConnection();
        $this->qb = $this->conn->createQueryBuilder();
        $this->db->setDbName('slimapp');
    }

    public function userExists(string $uid){
        return $this->qb->select("COUNT(*)")->from('users')->where("uid = ?")->setParameter(0, $uid)->executeQuery()->fetchOne();
    }

    public function insertUser(array $data){
        $params = [
                'uid'=>$data['uid']??'',
                'name'=>$data['name']??'',
                'email'=>$data['email']??'',
                'photo'=>$data['photo']??'',
                'providerId'=>$data['providerId']??'',
                'updated' => date('Y-m-d H:i:s')
        ];
        return $this->qb->insert('users')->values([
                'uid'=>':uid',
                'name'=>':name',
                'email'=>':email',
                'photo'=>':photo',
                'providerId'=>':providerId'
            ])->setParameters($params)->executeQuery();
    }

    public function updateUser(array $data){
        $params = [
                'uid'=>$data['uid']??'',
                'name'=>$data['name']??'',
                'email'=>$data['email']??'',
                'photo'=>$data['photo']??'',
                'providerId'=>$data['providerId']??'',
                'updated' => date('Y-m-d H:i:s')
        ];
        return $this->qb->update('users')
            ->set('name',':name')
            ->set('email',':email')
            ->set('photo',':photo')
            ->set('providerId',':providerId')->where('uid=:uid')
            ->set('updated',':updated')->setParameters($params)->executeQuery();
    }
}