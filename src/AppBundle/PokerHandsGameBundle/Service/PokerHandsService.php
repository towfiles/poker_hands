<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/20/19
 * Time: 11:00 AM
 */

namespace App\AppBundle\PokerHandsGameBundle\Service;

use App\AppBundle\PokerHandsGameBundle\Enums\CardPoints;
use App\Entity\PokerHands;
use App\Entity\PokerHandsFile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use SplFileObject;

class PokerHandsService
{
    private $entityManager;
    private $cardsService;

    public function __construct(EntityManagerInterface $entityManager, CardsService $cardsService)
    {
        $this->entityManager = $entityManager;
        $this->cardsService = $cardsService;

    }

    /**
     * @param UploadedFile $handsFile
     * @param User $currentUser
     * @return PokerHandsFile
     * @throws \Exception
     */
    public function UploadHands(UploadedFile $handsFile, User $currentUser) : PokerHandsFile
    {
        $pokerHandsFileObject = $this->entityManager
            ->getRepository(PokerHandsFile::class)->findOneBy(["user_id" => $currentUser->getId()]);
        if($pokerHandsFileObject){
            $this->entityManager->remove($pokerHandsFileObject);
            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        $pokerHandsFile = new PokerHandsFile();
        $pokerHandsFile->setFileName($handsFile->getClientOriginalName());
        $pokerHandsFile->setDateCreated(new \DateTime());
        $pokerHandsFile->setUserId($currentUser->getId());
        $this->entityManager->persist($pokerHandsFile);

        $fileObject = new SplFileObject($handsFile->getRealPath());
        //$count = 0;
        while (!$fileObject->eof()) {
            //if($count == 10) break;
            $pokerHand = new PokerHands();
            $pokerHandLine = trim($fileObject->fgets());
            if($pokerHandLine == "")  continue;
            $pokerHandLineArr = explode(' ', $pokerHandLine);
            if(count($pokerHandLineArr) !=  10){
                throw new \Exception("Error: Line Does not Contain 10 Cards. Hand Invalid");
            }

            $pokerHand->setPokerHandsFile($pokerHandsFile);
            $pokerHand->setPlayer1HandCard(array_slice($pokerHandLineArr, 0, 5));
            $pokerHand->setPlayer2HandCard(array_slice($pokerHandLineArr, 5));
            $this->entityManager->persist($pokerHand);
            //$count++;
        }
        unset($fileObject);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $pokerHandsFile;
    }


    /**
     * @param User $user
     * @return int
     */
    public function getPlayer1Wins(User $user) : int
    {
        $pokerHandsFileObject = $this->entityManager
            ->getRepository(PokerHandsFile::class)->findOneBy(["user_id" => $user->getId()]);

        $pokerHands = $pokerHandsFileObject->getPokerHands();
        $player1Wins = 0;
        foreach ($pokerHands as $pokerHand){
            $player1Point = $this->processPlayerPoints($pokerHand->getPlayer1HandCard());
            $player2Point = $this->processPlayerPoints($pokerHand->getPlayer2HandCard());
            if($player1Point > $player2Point){
                $player1Wins++;
            }
        }
        return $player1Wins;
    }

    /**
     * @param $playerHandCardArr
     * @return int
     */
    private function processPlayerPoints($playerHandCardArr) : int
    {
        $playerPoint = 0;

        if($value = $this->cardsService->isRoyalFlush($playerHandCardArr))
            $playerPoint = CardPoints::ROYAL_FLUSH + $value;

        elseif ($value = $this->cardsService->isStraightFlush($playerHandCardArr))
            $playerPoint = CardPoints::STRAIGHT_FLUSH + $value;

        elseif ($value = $this->cardsService->isFourOfAKind($playerHandCardArr))
            $playerPoint = CardPoints::FOUR_OF_A_KIND + $value;

        elseif ($value = $this->cardsService->isFullHouse($playerHandCardArr))
            $playerPoint = CardPoints::FULL_HOUSE + $value;

        elseif ($value = $this->cardsService->isFlush($playerHandCardArr))
            $playerPoint = CardPoints::FLUSH + $value;

        elseif ($value = $this->cardsService->isStraight($playerHandCardArr))
            $playerPoint = CardPoints::STRAIGHT + $value;

        elseif ($value = $this->cardsService->isThreeOfAKind($playerHandCardArr))
            $playerPoint = CardPoints::THREE_OF_A_KIND + $value;

        elseif ($value = $this->cardsService->isTwoPair($playerHandCardArr))
            $playerPoint = CardPoints::TWO_PAIRS + $value;

        elseif ($value = $this->cardsService->isOnePair($playerHandCardArr))
            $playerPoint = CardPoints::ONE_PAIR + $value;

        else $playerPoint = $this->cardsService->getHighCard($playerHandCardArr);

        return $playerPoint;
    }

}