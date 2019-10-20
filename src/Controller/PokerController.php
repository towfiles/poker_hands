<?php

namespace App\Controller;

use App\AppBundle\PokerHandsGameBundle\Entities\DataResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\AppBundle\PokerHandsGameBundle\Service\PokerHandsService;

class PokerController extends BaseController
{
    /**
     * @Route("/poker", name="poker")
     */
    public function index()
    {
        return $this->render('poker/index.html.twig', [
            'controller_name' => 'PokerController',
        ]);
    }

    /**
     * @Route("/upload-hands", name="upload_hands")
     */
    public function uploadHands(Request $request, PokerHandsService $pokerHandsService)
    {
        $handsFile = $request->files->get('file');
        try{
            if($handsFile){
                $pokerHandFile = $pokerHandsService->UploadHands($handsFile, $this->getUser());

                $response = new DataResponse();
                $response->data  =  ['fileName' => $pokerHandFile->getFileName(),
                    'dateCreated' => $pokerHandFile->getDateCreated()
                ];

                return $this->result($response);
            }
        }
        catch (FileException $ex) {
            return $this->resultWithErrors($ex->getMessage());
        }
    }

    /**
     * @Route("/player1-wins", name="player1-wins")
     */
    public function getPlayer1Wins(PokerHandsService $pokerHandsService){

        try{
            $player1Wins = $pokerHandsService->getPlayer1Wins($this->getUser());
            $response = new DataResponse();
            $response->data  =  ['wins' => $player1Wins];

            return $this->result($response);
        }
        catch (FileException $ex) {
            return $this->resultWithErrors($ex->getMessage());
        }

    }

}
