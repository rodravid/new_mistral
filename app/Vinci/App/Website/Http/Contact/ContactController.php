<?php

namespace Vinci\App\Website\Http\Contact;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;

class ContactController extends Controller
{
    protected $validator;

    public function __construct(EntityManagerInterface $em, ContactValidator $validator)
    {
        parent::__construct($em);
        $this->validator = $validator;
    }

    public function index()
    {
        return $this->view('contact.index');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $this->validator->with($data)->passesOrFail();

            Mail::send('website::contact.mail.default', compact('data'), function ($mail) use ($data) {
                $mail->from($data['email'], $data['name']);

                $mail->to('roliveira@webeleven.com.br', 'Rodrigo David de Oliveira')->subject(sprintf('Fale Conosco - %s', $data['subject']));
            });
            
            Flash::success('Mensagem Enviada! Agradecemos o seu contato e retornaremos o mais breve possível.');

            return Redirect::back();

        } catch (ValidationException $e) {

            Flash::error('Preencha os campos corretamente! \n\n A');
            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error('Não foi possível enviar sua dúvida. Por favor, tente novamente mais tarde');
            return Redirect::back()->withInput();
        }
    }

    private function getErrorsMessageFormated(array $errors)
    {

    }

}