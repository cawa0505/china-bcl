<?php

/**
 * Created by YLL Co Inc.
 * User: NiZerin
 * Email: nzl199851@163.com
 * Blog: nizer.in
 * Date: 5/29/2020
 * Time: 5:25 PM
 * FileName: Company.php
 */


namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Model\CompanyModel;
use App\Model\ProvinceModel;
use Exception;

/**
 * 公司
 * Class Company
 *
 * @package App\Http\Controllers\Index
 */
class Company extends Controller
{
    /**
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(int $id)
    {
        return view('home.company.list', ['id' => $id]);
    }

    /**
     * @param  int  $id
     *
     * @return array
     */
    public function list(int $id)
    {
        $company = CompanyModel ::query()
            -> where('province_id', $id)
            -> orderByDesc('id')
            -> paginate(request() -> post('limit', 30));

        return [
            'code'  => 0,
            'msg'   => 'success',
            'count' => $company -> total(),
            'data'  => $company -> items(),
        ];
    }

    /**
     * 新增公司页面
     */
    public function add()
    {
        return view('home.company.add', [
            'provinces' => ProvinceModel ::query() -> get(),
        ]);
    }

    /**
     * 新增公司保存
     * @return array
     */
    public function save()
    {
        $data = html_charset();
        $data['from_ip'] = request()->ip();

        try {
            CompanyModel ::query() -> create($data);

            return ['code' => 0, 'data' => [], 'msg' => 'success'];
        } catch (Exception $exception) {
            return ['code' => 1, 'data' => [], 'msg' => $exception -> getMessage()];
        }
    }

}
