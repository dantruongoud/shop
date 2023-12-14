<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];
    public $total = 0;
    public $products = [];
    public $qty = 0;
    public $phone;
    public $name;
    public $address;
    /**
     * Create a new message instance.
     * 
     * @return void
     */
    public function __construct($data, $total, $products, $qty, $phone, $name, $address)
    {
        $this->data = $data;
        $this->total = $total;
        $this->products = $products;
        $this->qty = $qty;
        $this->phone = $phone;
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * Build the message.
     * 
     * @return $this
     */
    public function build()
    {
        return $this->from('nguyendantruongg@gmail.com', 'test')->subject($this->data['subject'])->view('frontend.email.index')
        ->with('data', $this->data)->with('total', $this->total)
        ->with('Product', $this->products)->with('Quantity', $this->qty)
        ->with('phone', $this->phone)->with('name', $this->name)
        ->with('address', $this->address);
    }

}
