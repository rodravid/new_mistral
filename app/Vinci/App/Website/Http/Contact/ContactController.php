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

                $mail->to(env('MAIL_FROM_ADDRESS_RESET'), env('MAIL_FROM_NAME'))->subject(sprintf('Fale Conosco - %s', $data['subject']));
            });
            
            Flash::success('Mensagem Enviada! Agradecemos o seu contato e retornaremos o mais breve possível.');
            return Redirect::back();

        } catch (ValidationException $e) {
            $flashMessage = $this->getErrorsMessageFormated($e);

            Flash::error($flashMessage);
            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error('Não foi possível enviar sua dúvida. Por favor, tente novamente mais tarde');
            return Redirect::back()->withInput();
        }
    }

    private function getErrorsMessageFormated($e)
    {
        $flashMessage = 'Preencha os campos corretamente! \n\n';

        foreach ($e->getErrors()->getMessages() as $errorMessage) {
            $flashMessage .= $errorMessage[0] . '\n';
        }

        return $flashMessage;
    }

}