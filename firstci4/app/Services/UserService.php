<?php
namespace App\Services;

use App\Models\CustomerModel;
use App\Common;
use App\Common\ResultUtils;
use Exception;

class UserService extends BaseService{

    protected $customerModel;

    function __construct()
    {
        parent::__construct();
        $this->customerModel = model(CustomerModel::class);  
        $this->customerModel->protect(false);  
    }

    public function getCategories() 
    {
        return $this->customerModel->getCategories();
    } 
    
    public function getProductGender($gioitinhGet) 
    {
        return $this->customerModel->getProductGender($gioitinhGet);
    } 

    public function getProducts() 
    {
        return $this->customerModel->getProducts();
    } 

    public function checkLoginCusomer($checkRequest, $checkSubmit, $emaillogin, $pwdlogin) 
    {
        if(isset($checkSubmit)){
            return $this->customerModel->checkLoginCusomer($checkRequest, $checkSubmit, $emaillogin, $pwdlogin);        
        }
    } 

    // public function RegisterCustomer($checkSubmit ,$emailPost, $pwdPost, $dobPost, $genderPost) 
    // {
    //     if(isset($checkSubmit)){
    //         return $this->customerModel->RegisterCustomer($checkSubmit ,$emailPost, $pwdPost, $dobPost, $genderPost);        
    //     }
    // } 

    public function submitOrder($checkSubmit, $fullname, $address, $phoneNumber, $totalPrice, $customer_login, $cart)
     {
        if(isset($checkSubmit)) {
            return $this->customerModel->submitOrder($checkSubmit, $fullname, $address, $phoneNumber, $totalPrice, $customer_login, $cart);
        }
    } 
    
    public function getProductsId($idsanpham) 
    {
        return $this->customerModel->getProductsId($idsanpham);
    } 

    public function getUnitColorProduct($skuProduct) 
    {
        return $this->customerModel->getUnitColorProduct($skuProduct); 
    } 

    public function getProductAttributeId($idsanpham) 
    {
        return $this->customerModel->getProductAttributeId($idsanpham);
    } 
    public function getProductCategory($iddanhmuc, $gioitinh) 
    {
        return $this->customerModel->getProductCategory($iddanhmuc, $gioitinh);
    } 
    public function getProductAttribute() 
    {
        return $this->customerModel->getProductAttribute();
    } 

    public function addToCart($checkSubmit, $color_prd, $size_prd , $quantity_prd, $checkLogin, $idsanpham) {
        if(isset($checkSubmit)){
            $this->customerModel->addToCart($color_prd, $size_prd , $quantity_prd, $checkLogin, $idsanpham);
        }    
    } 
 
    public function RegisterCustomer($requestData)
    {
        $validate = $this->validateAddCustomer($requestData);

        if($validate->getErrors()){
            return [
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR, 
                'massages' => $validate->getErrors(),
            ];
        }

        $dataSave = $requestData->getPost();
        unset($dataSave['password_confirm']); 
        $dataSave['password'] = password_hash($dataSave['password'], PASSWORD_BCRYPT);
        
        try {
            $this->customerModel->RegisterCustomer($dataSave['name'], $dataSave['email'], $dataSave['password'], $dataSave['dob'], $dataSave['gender']);
            return [ 
                'status' => ResultUtils::STATUS_CODE_OK,
                'massageCode' => ResultUtils::MESSAGE_CODE_OK,
                'massages' => ['success' => 'Thêm dữ liệu thành công'], 
            ];

        } catch (Exception $e) {
            return [ 
                'status' => ResultUtils::STATUS_CODE_ERR,
                'massageCode' => ResultUtils::MESSAGE_CODE_ERR,
                'massages' => ['error' => $e->getMessage()], 
            ];
        }

    }

    private function validateAddCustomer($requestData) 
    {
        $rules = [
            'name' => 'max_length[100]',
            'email' => 'valid_email|is_unique[customers.email]',
            'password' => 'max_length[30]|min_length[6]',
            'password_confirm' => 'matches[password]',
            'dob' => 'min_length[8]',
            'gender' => 'min_length[3]',
        ];

        $messages = [
            'name' => [
                'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự!',
            ],
            'email' => [
                'valid_email' => 'Tài khoản {field} {value} không đúng định dạng!',
                'is_unique' => 'Email đã được đăng ký, vui lòng kiểm tra lại!'
            ],
            'password' => [
                'max_length' => 'Mật khẩu quá dài, vui lòng nhập {param} ký tự!',
                'min_length' => 'Mật khẩu ít nhất là {param} ký tự!',
            ],
            'password_confirm' => [
                'matches' => 'Mật khẩu không khớp!',
            ]
        ];

        // reset all previous errors
        $this->validation->reset();

        $this->validation->setRules($rules, $messages);
        $this->validation->withRequest($requestData)->run(); 

        return $this->validation;
    }
}