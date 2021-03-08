<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateOrder;
use App\Http\Requests\UpdateOrder;
use App\Jobs\SendEmailJob;
use App\Orders;
use Illuminate\Http\Request;
use Mail;

class OrderController extends Controller
{
    public function index($companies_id = null)
    {
        if($companies_id == null){
            return redirect()->route('companies');
        }
        $company = Company::where("id",$companies_id)->first();
        if($company == null){
            return redirect()->route('companies');
        }
        return view('orders.index',compact('companies_id'));
    }

    public function orders_ajax(Request $request)
    {
        $columns = array(
            0 =>'id',
            1 =>'name',
            2=> 'price',
            3=> 'created_at',
            4=> 'id',
        );

        $totalData = Orders::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $orders = Orders::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $orders =  Orders::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Orders::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($orders))
        {
            foreach ($orders as $order)
            {
                $edit =  route('orders.edit',$order->id);

                $nestedData['id'] = $order->id;
                $nestedData['name'] = $order->name;
                $nestedData['price'] = $order->price;
                $nestedData['text'] = substr(strip_tags($order->text),0,50)."...";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($order->created_at));
                $nestedData['options'] = "<a href='{$edit}' name='EDIT' >Edit</a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }

    public function create($companies_id = null)
    {
        if($companies_id == null){
            return redirect()->route('companies');
        }
        $company = Company::where("id",$companies_id)->first();
        if($company == null){
            return redirect()->route('companies');
        }
        $order = new Orders;
        return view('orders.create', compact('company','companies_id','order'));
    }

    public function store(CreateOrder $request)
    {
        $order = Orders::create($request->all());


        $from_email = env('MAIL_USERNAME');
        $to_name = env('MAIL_USERNAME');
        $to_email = "info@pretendcompany.com";

        $data = array('name' => $request->name,'price' => $request->price,'text' =>$request->text);

        Mail::send(['html' => 'emails.orders'], $data, function ($message) use ($to_name, $to_email, $from_email) {
            $message->to($to_email, $to_name)
                ->subject('Order');
            $message->from($from_email,'Order');
        });

        return redirect()->route('orders',['companies_id'=>$order->companies_id])->with('alert', 'Orders created!');
    }

    public function edit($contact)
    {
        $order = Orders::where("id",$contact)->first();
        if($order == null){
            return redirect()->route('companies');
        }
        $companies_id = $order->companies_id;
        return view('orders.edit', compact('order','companies_id'));
    }

    public function update(UpdateOrder $request, $order)
    {
        $order = Orders::where("id",$order)->first();
        if($order == null){
            return redirect()->route('companies');
        }

        $order->update($request->all());

        $date = $order->created_at->addMinutes(30);

        $message = "Order Name : " . $order->name;
     //   \Queue::later($date, 'SendEmailJob', array('message' => $message));
        dispatch(new SendEmailJob());

        return redirect()->route('orders',['companies_id'=>$order->companies_id])->with('alert', 'Orders updated!');
    }
}
