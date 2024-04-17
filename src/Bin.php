<?php

/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 * @author    Maksym Medar
 *
 */

namespace Latuconsinafr\BinPackager\BinPackager3D;

use ArrayIterator;
use JsonSerializable;
use Latuconsinafr\BinPackager\BinPackager3D\Handlers\IntersectionHandler;
use Latuconsinafr\BinPackager\BinPackager3D\Types\AxisType;
use Latuconsinafr\BinPackager\BinPackager3D\Types\RotationCombinationType;

/**
 * A class representative of a single bin to put @see Item into.
 */
final class Bin implements JsonSerializable
{
    /**
     * @var mixed The bin's id.
     */
    private $id;

    /**
     * @var float The bin's length.
     */
    private $length;

    /**
     * @var float The bin's breadth.
     */
    private $breadth;

    /**
     * @var float The bin's height.
     */
    private $height;

    /**
     * @var float The bin's volume.
     */
    private $volume;

    /**
     * @var float The bin's weight.
     */
    private $weight;

    /**
     * @var iterable The fitted item(s) inside the bin.
     */
    private $fittedItems;

    /**
     * @var float The total fitted bin's volume.
     */
    private $totalFittedVolume;

    /**
     * @var float The total fitted bin's weight.
     */
    private $totalFittedWeight;

    /**
     * @var iterable The unfitted item(s).
     */
    private $unfittedItems;

    /**
     * @var float The total unfitted bin's volume.
     */
    private $totalUnfittedVolume;

    /**
     * @var float The total unfitted bin's weight.
     */
    private $totalUnfittedWeight;

    /**
     * @param mixed $id The identifier of the bin.
     * @param float $length The length of the bin.
     * @param float $height The height of the bin.
     * @param float $breadth The breadth of the bin.
     * @param float $weight The weight of the bin.
     */
    public function __construct($id, $length, $height, $breadth, $weight)
    {
        $this->id = $id;

        $this->length  = $length;
        $this->height  = $height;
        $this->breadth = $breadth;
        $this->volume  = (float)$this->length * $this->height * $this->breadth;
        $this->weight  = $weight;

        $this->fittedItems       = [];
        $this->totalFittedVolume = 0;
        $this->totalFittedWeight = 0;

        $this->unfittedItems       = [];
        $this->totalUnfittedVolume = 0;
        $this->totalUnfittedWeight = 0;
    }

    /**
     * The bin's id getter.
     *
     * @return mixed The bin's id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The bin's length getter.
     *
     * @return float The bin's length.
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * The bin's height getter.
     *
     * @return float The bin's height.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * The bin's breadth getter.
     *
     * @return float The bin's breadth.
     */
    public function getBreadth()
    {
        return $this->breadth;
    }

    /**
     * Get the bin's volume.
     *
     * @return float The bin's volume.
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * The bin's weight getter.
     *
     * @return float The bin's weight.
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * The bin's fitted items' getter.
     *
     * @return iterable The bin's fitted items.
     */
    public function getFittedItems()
    {
        return $this->fittedItems;
    }

    /**
     * The bin's iterable fitted items' getter.
     *
     * @return ArrayIterator The bin's iterable fitted items.
     */
    public function getIterableFittedItems()
    {
        return new ArrayIterator($this->fittedItems);
    }

    /**
     * The bin's unfitted items getter.
     *
     * @return iterable The bin's unfitted items.
     */
    public function getUnfittedItems()
    {
        return $this->unfittedItems;
    }

    /**
     * The bin's iterable unfitted items' getter.
     *
     * @return ArrayIterator The bin's iterable unfitted items.
     */
    public function getIterableUnfittedItems()
    {
        return new ArrayIterator($this->unfittedItems);
    }

    /**
     * Get the bin's total fitted volume.
     *
     * @return float The fitted bin's volume.
     */
    public function getTotalFittedVolume()
    {
        return $this->totalFittedVolume;
    }

    /**
     * Get the bin's total fitted weight.
     *
     * @return float The fitted bin's weight.
     */
    public function getTotalFittedWeight()
    {
        return $this->totalFittedWeight;
    }

    /**
     * Get the bin's total unfitted volume.
     *
     * @return float The unfitted bin's volume.
     */
    public function getTotalUnfittedVolume()
    {
        return $this->totalUnfittedVolume;
    }

    /**
     * Get the bin's total unfitted weight.
     *
     * @return float The unfitted bin's weight.
     */
    public function getTotalUnfittedWeight()
    {
        return $this->totalUnfittedWeight;
    }

    /**
     * Set the number of digits after the decimal point of bin's values.
     *
     * @param mixed $precision The number of digits after the decimal point.
     *
     * @return void
     */
    public function setPrecision($precision)
    {
        $this->length  = round($this->length, $precision);
        $this->height  = round($this->height, $precision);
        $this->breadth = round($this->breadth, $precision);
        $this->volume  = round($this->volume, $precision);
        $this->weight  = round($this->weight, $precision);
    }

    /**
     * The bin's fitted items' setter.
     * The parameter value should be an instance of Item class.
     *
     * @return void
     */
    public function setFittedItems(Item $item)
    {
        $this->fittedItems[]     = $item;
        $this->totalFittedVolume += $item->getVolume();
        $this->totalFittedWeight += $item->getWeight();
    }

    /**
     * The bin's unfitted items' setter.
     * The parameter value should be an instance of Item class.
     *
     * @return void
     */
    public function setUnfittedItems(Item $item)
    {
        $this->unfittedItems[]     = $item;
        $this->totalUnfittedVolume += $item->getVolume();
        $this->totalUnfittedWeight += $item->getWeight();
    }

    /**
     * The put item into the bin method.
     *
     * @param Item $item The item to put into.
     * @param array $position The starting position.
     *
     * @return bool The flag indicates whether the item can fit into the bin or not,
     * return true if the item can fit into the bin, otherwise false.
     */
    public function putItem(Item $item, array $position)
    {
        $fit               = false;
        $validItemPosition = $item->getPosition();
        $item->setPosition($position);

        foreach (RotationCombinationType::ALL_ROTATION_COMBINATION as $rotationType) {
            $item->setRotationType($rotationType);
            $dimension = $item->getDimension();

            if (
                $this->length < $position[AxisType::LENGTH] + $dimension[AxisType::LENGTH] ||
                $this->height < $position[AxisType::HEIGHT] + $dimension[AxisType::HEIGHT] ||
                $this->breadth < $position[AxisType::BREADTH] + $dimension[AxisType::BREADTH]
            ) {
                continue;
            }

            $fit = true;

            foreach ($this->fittedItems as $fitted_item) {
                if (IntersectionHandler::isIntersected($fitted_item, $item)) {
                    $fit = false;

                    break;
                }
            }

            if ($fit) {
                if (($this->totalFittedWeight + $item->getWeight()) > $this->weight) {
                    return false;
                }

                $this->setFittedItems($item);
            }

            if (!$fit) {
                $item->setPosition($validItemPosition);
            }

            return $fit;
        }

        if (!$fit) {
            $item->setPosition($validItemPosition);
        }

        return $fit;
    }

    /**
     * The json serialize method.
     *
     * @return array The resulted object.
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
