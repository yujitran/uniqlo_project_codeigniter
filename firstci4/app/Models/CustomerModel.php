<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    public function getAllCustomer()
    {
        $db = $this->db;
        $builder = $db->table('customers');
        $builder->select('*');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getUser($email)
    {
        $db = $this->db;
        $builder = $db->table('customers');
        $builder->select('*');
        $builder->where('email', $email);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProductGender($gender)
    {
        $db = $this->db;
        $builder = $db->table('products');
        $builder->select('*');
        $builder->where('gender', $gender);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProducts()
    {
        $db = db_connect();
        $builder = $db->table('products');
        $builder->select('*');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProductsId($idsanpham)
    {
        $db = $this->db;
        $builder = $db->table('products');
        $builder->select('*');
        $builder->where('product_id', $idsanpham);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProductCategory($category_id, $gender)
    {
        $db = $this->db;
        $builder = $db->table('products');
        $builder->select('*');
        $builder->where('category_id', $category_id);
        $builder->where('gender', $gender);
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function getProductAttribute()
    {
        $db = $this->db;
        $query = $db->query('SELECT products.product_id, attributes.unit, attributes.name
        FROM products, attributes, product_attribute
        WHERE product_attribute.product_id = products.product_id
        AND product_attribute.attribute_id = attributes.attribute_id');
        $result = $query->getResultArray();

        return $result;
    }

    public function getProductAttributeId($idProduct)
    {
        $db = $this->db;
        $query = $db->query("SELECT products.product_id, attributes.attribute_id, attributes.name, attributes.attribute_sku, attributes.unit
        FROM products, attributes, product_attribute
        WHERE products.product_id = $idProduct
        AND product_attribute.product_id = products.product_id
        AND product_attribute.attribute_id = attributes.attribute_id
        ");
        $result = $query->getResultArray();

        return $result;
    }

    public function getUnitColorProduct($skuProduct, $gender)
    {
        $sql = "SELECT product_id FROM products 
        WHERE sku = '$skuProduct' AND gender = '$gender'
        ";
        $result = $this->db->query($sql);
        $data = [];

        foreach ($result->getResultArray() as $row => $val) {
            foreach ($val as $item) {
                $sqlUnit = "SELECT attributes.unit, products.product_id, products.gender
                FROM products, attributes, product_attribute
                WHERE products.product_id = $item
                AND attributes.name = 'color'
                AND product_attribute.product_id = products.product_id
                AND product_attribute.attribute_id = attributes.attribute_id
                ";

                $resultUnit = $this->db->query($sqlUnit);
                $data[] = $resultUnit->getResultArray();
            }
        }

        return $data;
    }

    public function getCategories()
    {
        $db = $this->db;
        $builder = $db->table('categories');
        $builder->select('*');
        $result = $builder->get()->getResultArray();

        return $result;
    }

    public function RegisterCustomer($namePost, $emailPost, $pwdPost, $dobPost, $genderPost)
    {
        if (isset($namePost) && isset($emailPost) && isset($pwdPost) && isset($dobPost) && isset($genderPost)) {

            $db = $this->db;
            $builder = $db->table('customers');
            $builder->select('*');
            $builder->where('email', $emailPost);
            $resultEmail = $builder->countAllResults();

            //check email and phone exists
            if ($resultEmail > 0) {
                // echo "<br/>" . "Email is already used";
            } else {
                // Prepare the Query
                $pQuery = $db->prepare(static function ($db) {
                    return $db->table('customers')->insert([
                        'name'    => 'n',
                        'email'    => 'x',
                        'password'    => 'y',
                        'dob'    => 'z',
                        'gender'    => 'a',
                    ]);
                });

                // Run the Query
                $pQuery->execute($namePost, $emailPost, $pwdPost, $dobPost, $genderPost);
                // Close out the prepared statement
                $pQuery->close();
            }
        } else {
            return "";
        }
    }

    public function checkLoginCusomer($submitLogin, $emaillogin)
    {
        if(isset($submitLogin)){
            // die($emaillogin);
            $db = $this->db;
            $builder = $db->table('customers');
            $builder->select('*');
            $builder->where('email', $emaillogin);
            $result = $builder->get()->getResultArray();
    
            return $result;
        }
    }

    public function updateUserModel($email, $pwd, $dob, $gender, $id)
    {
        $db = $this->db;

        // Prepare the Query
        $pQuery = $db->prepare(static function ($db) {
            return $db->table('customers')->update([
                'email'    => 'x',
                'password'    => 'y',
                'dob'    => 'z',
                'gender'    => 'a',
            ]);
        });

        $db->table('customers')->where('id_customer', $id);

        // Run the Query
        $pQuery->execute($email, $pwd, $dob, $gender);
        // Close out the prepared statement
        $pQuery->close();
    }

    public function addToCart($color_prd, $size_prd, $quantity_prd, $idsanpham)
    {
        if (isset($color_prd)  && isset($size_prd) && isset($quantity_prd)) {
            if (isset($_SESSION['customer_login'])) { 
                $db = $this->db;
                $builder = $db->table('products');
                $builder->select('*');
                $builder->where('product_id', $idsanpham);
                $result = $builder->get(1)->getResultArray();

                foreach ($result as $row) {
                    $_SESSION['cart'][$idsanpham]['sku'] = $row['sku'];
                    $_SESSION['cart'][$idsanpham]['title'] = $row['title'];
                    $_SESSION['cart'][$idsanpham]['price'] = $row['price'];
                    $_SESSION['cart'][$idsanpham]['thumbnail'] = $row['thumbnail'];
                }

                $_SESSION['cart'][$idsanpham]['color'] = $_POST['color_prd'];
                $_SESSION['cart'][$idsanpham]['size'] = $_POST['size_prd'];
                $_SESSION['cart'][$idsanpham]['quantity'] = $_POST['quantity_prd'];
            }
        }
    }

    public function submitOrder($fullname, $address, $phoneNumber, $totalPrice)
    {
        if (empty($fullname) && empty($address) && empty($phoneNumber) && empty($totalPrice)) {
            $db = $this->db;

            // Prepare the Query
            $pQuery = $db->prepare(static function ($db) {
                return $db->table('orders')->insert([
                    'customer_id'    => 'x',
                    'fullname'    => 'y',
                    'address'    => 'z',
                    'phone_number'    => 'a',
                    'total_price'    => 'b',
                ]);
            });

            foreach ($_SESSION['customer_login'] as $key) {
                $customerId = $key['customer_id'];
            }

            // Run the Query
            $pQuery->execute($customerId, $fullname, $address, $phoneNumber, $totalPrice);
            // Close out the prepared statement
            $pQuery->close();


            $sqlOrderId = $db->query("SELECT * FROM orders WHERE customer_id = '$customerId' ORDER BY order_id DESC LIMIT 1");

            foreach ($sqlOrderId->getResultArray() as $row) {
                $id_order = $row['order_id'];
            }

            foreach ($_SESSION['cart'] as $id => $each) {
                $order_id = "";
                $product_id = "";
                $price = "";
                $quantity = "";
                $total_momney = "";

                // Prepare the Query
                $pQuery = $db->prepare(static function ($db) {
                    return $db->table('order_items')->insert([
                        'order_id'    => 'x',
                        'product_id'    => 'y',
                        'price'    => 'z',
                        'quantity'    => 'a',
                        'total_money'    => 'b',
                    ]);
                });

                $row = $_SESSION['customer_login'];
                foreach ($row as $key) {
                    $customerId = $key['customer_id'];
                }

                $order_id = $id_order;
                $product_id = $id;
                $price = $each['price'];
                $quantity = $each['quantity'];
                $total_momney = $each['price'] * $each['quantity'];

                // Run the Query
                $pQuery->execute($order_id, $product_id, $price, $quantity, $total_momney);
                // Close out the prepared statement
                $pQuery->close();
                unset($_SESSION['cart']);
            }

            return true;
        } else {
            return false;
        }
    }

    public function submitOrderOnlinePayment($fullName, $addressOrder, $phoneNumberOrder, $totalPriceOrder, $order_code, $bankCode, $bankTranNo, $transactionNo, $orderInfo, $payDate)
    {
        $db = $this->db;

        // Prepare the Query
        $pQuery = $db->prepare(static function ($db) {
            return $db->table('online_payment')->insert([
                'customer_id'    => 'x',
                'order_id'    => 'y',
                'order_code'    => 'z',
                'bank_code'    => 'a',
                'bank_tran_no'    => 'b',
                'transaction_no'    => 'c',
                'content'    => 'e',
                'amount'    => 'f',
                'pay_date'    => 'g',
            ]);
        });

        $row = $_SESSION['customer_login'];
        foreach ($row as $key) {
            $customerId = $key['customer_id'];
        }

        $sqlOrderId = $db->query("SELECT * FROM orders WHERE customer_id = '$customerId' ORDER BY order_id DESC LIMIT 1");

        foreach ($sqlOrderId->getResultArray() as $row) {
            $id_order = $row['order_id'];
        }

        // Run the Query
        $pQuery->execute($customerId, $id_order, $order_code, $bankCode, $bankTranNo, $transactionNo, $orderInfo, $totalPriceOrder, $payDate);
        // Close out the prepared statement
        $pQuery->close();
        
        $this->submitOrder($fullName, $addressOrder, $phoneNumberOrder, $totalPriceOrder);
    }
}
