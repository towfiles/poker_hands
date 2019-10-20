<?php
/**
 * Created by PhpStorm.
 * User: toby
 * Date: 10/20/19
 * Time: 1:58 PM
 */

namespace App\AppBundle\PokerHandsGameBundle\Service;


/**
 * Cards Service Class Processes cards by hand and determine what
 * types of cards they are
 * Class CardsService
 * @package App\AppBundle\PokerHandsGameBundle\Service
 */
class CardsService
{

    /**
     * return an array of only the card values on a poker hand
     * @param $pokerHandArr
     * @return array
     */
    private function getCardValues($pokerHandArr) :array
    {
        $counter = 0;
        $cardValueArray = [];
        foreach ($pokerHandArr as $card)
        {
            if ($card[0] == 'T')
                $cardValueArray[$counter] = 10;
            else if ($card[0] == 'J')
                $cardValueArray[$counter] = 11;
            else if ($card[0] == 'Q')
                $cardValueArray[$counter] = 12;
            else if ($card[0] == 'K')
                $cardValueArray[$counter] = 13;
            else if ($card[0] == 'A')
                $cardValueArray[$counter] = 14;
            else
                $cardValueArray[$counter] = $card[0];
            $counter++;
        }
        sort($cardValueArray);
        return $cardValueArray;
    }

    /**
     * Check if poker hand is royal flush,
     * it returns the highest card value if poker Hand is Royal Flush
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isRoyalFlush($pokerHandArr)
    {
        if($this->isFlush($pokerHandArr)){
            $cardValueArray = $this->getCardValues($pokerHandArr);
            foreach ($pokerHandArr as $card)
            {
                if($card[0] == 'T' || $card[0] == 'J' || $card[0] == 'Q' || $card[0] == 'K' || $card[0] == 'A'){
                    $royalFlush = $cardValueArray[4];
                }
                else
                {
                    $royalFlush = false;
                    break;
                }
            }
            return $royalFlush;
        }
        return false;

    }

    /**
     * Check if poker hand is straight flush,
     * it returns the highest card value if poker Hand is straight Flush
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isStraightFlush($pokerHandArr)
    {
        if($this->isFlush($pokerHandArr)){
            return $this->isStraight($pokerHandArr);
        }

        return false;
    }

    /**
     * Check if poker hand is four of a kind,
     * it returns the highest card value if poker Hand is four of a kind
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isFourOfAKind($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) )
                $dictionary[$card] = 1;
            else
            {
                $dictionary[$card]++;
            }
        }
        foreach (array_keys($dictionary) as $key)
        {
            if ($dictionary[$key] == 4)
                return $cardValueArray[4];
        }
        return false;
    }

    /**
     * Check if poker hand is full house,
     * it returns the highest card value if poker Hand is full house
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isFullHouse($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) ) {
                $dictionary[$card] = 1;
            }
            else
            {
                $dictionary[$card]++;
            }
        }
        if (count($dictionary) == 2)
        {
            foreach (array_keys($dictionary) as $key)
            {
                if ($dictionary[$key] == 3)
                    return $cardValueArray[4];
            }
        }
            return false;

    }

    /**
     * Check if poker hand is flush,
     * it returns the highest card value if poker Hand is Flush
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isFlush($pokerHandArr)
    {
        $flushCheck = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        foreach ($pokerHandArr as $card)
        {
            if(!in_array($card[1], $flushCheck)){
                $flushCheck[] = $card[1];
            }
        }
        if(count($flushCheck) == 1){
            return $cardValueArray[4];
        }
        return false;
    }

    /**Check if poker hand is straight,
     * it returns the highest card value if poker Hand is Straight
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isStraight($pokerHandArr)
    {

        $cardValueArray = $this->getCardValues($pokerHandArr);

            if ($cardValueArray[0] + 1 == $cardValueArray[1] &&
                $cardValueArray[1] + 1 == $cardValueArray[2] &&
                $cardValueArray[2] + 1 == $cardValueArray[3] &&
                $cardValueArray[3] + 1 == $cardValueArray[4]
            )
            {
                return $cardValueArray[4];
            }
            else if ($cardValueArray[0] == 2 &&
                $cardValueArray[1] == 3 &&
                $cardValueArray[2] == 4 &&
                $cardValueArray[3] == 5 &&
                $cardValueArray[4] == 14
            )
            {
                return  $cardValueArray[4];
            }

        return false;
    }

    /**
     * Check if poker hand is 3 of a kind,
     * it returns the highest card value if poker Hand is 3 of a kind
     * @param $pokerHandArr
     * @return bool|mixed
     */
    public function isThreeOfAKind($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) )
                $dictionary[$card] = 1;
            else
            {
                $dictionary[$card]++;
            }
        }
        foreach (array_keys($dictionary) as $key)
        {
            if ($dictionary[$key] == 3)
                return $cardValueArray[4];
        }
        return false;
    }

    /**
     * Check if poker hand is 2 pair
     * @param $pokerHandArr
     * @return bool
     */
    public function isTwoPair($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) )
                $dictionary[$card] = 1;
            else
            {
                $dictionary[$card]++;
            }
        }
        if (count($dictionary) == 3) $cardValueArray[4];

        return false;

    }

    /**
     * Check if poker hand is one pair
     * @param $pokerHandArr
     * @return bool
     */
    public function isOnePair($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);

        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) )
                $dictionary[$card] = 1;
            else
            {
                $dictionary[$card]++;
            }
        }
        if (count($dictionary) == 4) $cardValueArray[4];

        return false;
    }

    /**
     * returns one pair of a poker hand
     * @param $pokerHandArr
     * @return int|mixed
     */
    public function getOnePair($pokerHandArr)
    {
        $dictionary = [];
        $cardValueArray = $this->getCardValues($pokerHandArr);
        $pair = 0;
        foreach ($cardValueArray as $card)
        {
            if ( !array_key_exists($card, $dictionary) )
                $dictionary[$card] = 1;
            else
            {
                $dictionary[$card]++;
                $pair = $card;
            }
        }
        if (count($dictionary) == 4) return $pair;

        return 0;
    }

    /**
     * returns the highest card in a poker hand
     * @param $pokerHandArr
     * @return mixed
     */
    public function getHighCard($pokerHandArr)
    {
        $cardValueArray = $this->getCardValues($pokerHandArr);
        return $cardValueArray[4];
    }

}