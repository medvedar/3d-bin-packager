<?php

/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 * @author    Maksym Medar
 */

namespace Latuconsinafr\BinPackager\BinPackager3D;

use Latuconsinafr\BinPackager\BinPackager3D\Types\AxisType;
use Latuconsinafr\BinPackager\BinPackager3D\Types\PositionType;
use Latuconsinafr\BinPackager\BinPackager3D\Types\RotationCombinationType;

/**
 * A class representative of a single item to put into the @see Bin.
 */
final class Item implements \JsonSerializable
{
    /**
     * @var mixed The item's id.
     */
    private $id;

    /**
     * @var float The item's length.
     */
    private $length;

    /**
     * @var float The item's breadth.
     */
    private $breadth;

    /**
     * @var float The item's height.
     */
    private $height;

    /**
     * @var float The item's volume.
     */
    private $volume;

    /**
     * @var float The item's weight.
     */
    private $weight;

    /**
     * @var int The item's current rotation type.
     */
    private $rotationType;

    /**
     * @var array The item's current position.
     */
    private $position;

    /**
     * @param mixed $id The identifier of the item.
     * @param float $length The length of the item.
     * @param float $height The height of the item.
     * @param float $breadth The breadth of the item.
     * @param float $weight The weight of the item.
     */
    public function __construct($id, $length, $height, $breadth, $weight)
    {
        $this->id = $id;

        $this->length = $length;
        $this->height = $height;
        $this->breadth = $breadth;
        $this->volume = (float) $this->length * $this->height * $this->breadth;
        $this->weight = $weight;

        $this->rotationType = RotationCombinationType::LHB_ROTATION;
        $this->position = PositionType::START_POSITION;
    }

    /**
     * The item's id getter.
     * 
     * @return mixed The item's id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The item's length getter.
     * 
     * @return float The item's length.
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * The item's height getter.
     * 
     * @return float The item's height.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * The item's breadth getter.
     * 
     * @return float The item's breadth.
     */
    public function getBreadth()
    {
        return $this->breadth;
    }

    /**
     * The item's volume getter.
     * 
     * @return float The item's volume.
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * The item's weight getter.
     * 
     * @return float The item's weight.
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * The item's rotation type getter.
     * 
     * @return int The item's rotation type.
     */
    public function getRotationType()
    {
        return $this->rotationType;
    }

    /**
     * The item's position type getter.
     * In this case, it would return an array of 3 values representations of the x-axis, y-axis and z-axis (3d plane).
     * 
     * @return array The item's position (for example = ['x-axis => 0, 'y-axis' => 0, 'z-axis' => 0]).
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get the item's dimension based on the rotation type.
     * In this case, it would return an array of 3 values representations of the x-axis, y-axis and z-axis (3d plane).
     * 
     * @return array The item's dimension (for example = ['x-axis => 0, 'y-axis' => 0, 'z-axis' => 0]).
     */
    public function getDimension()
    {
        switch ($this->rotationType) {
            case RotationCombinationType::LHB_ROTATION:
                return [
                    AxisType::LENGTH => $this->length,
                    AxisType::HEIGHT => $this->height,
                    AxisType::BREADTH => $this->breadth
                ];

            case RotationCombinationType::LBH_ROTATION:
                return [
                    AxisType::LENGTH => $this->length,
                    AxisType::HEIGHT => $this->breadth,
                    AxisType::BREADTH => $this->height
                ];

            case RotationCombinationType::HLB_ROTATION:
                return [
                    AxisType::LENGTH => $this->height,
                    AxisType::HEIGHT => $this->length,
                    AxisType::BREADTH => $this->breadth
                ];

            case RotationCombinationType::HBL_ROTATION:
                return [
                    AxisType::LENGTH => $this->height,
                    AxisType::HEIGHT => $this->breadth,
                    AxisType::BREADTH => $this->length
                ];

            case RotationCombinationType::BLH_ROTATION:
                return [
                    AxisType::LENGTH => $this->breadth,
                    AxisType::HEIGHT => $this->length,
                    AxisType::BREADTH => $this->height
                ];

            case RotationCombinationType::BHL_ROTATION:
                return [
                    AxisType::LENGTH => $this->breadth,
                    AxisType::HEIGHT => $this->height,
                    AxisType::BREADTH => $this->length
                ];

            default:
                throw new \UnexpectedValueException("Invalid rotation combination type, the value should be in between 0 and 5.");
        }
    }

    /**
     * Set the number of digits after the decimal point of item's values.
     * 
     * @param mixed $precision The number of digits after the decimal point.
     * 
     * @return void
     */
    public function setPrecision($precision)
    {
        $this->length = round($this->length, $precision);
        $this->height = round($this->height, $precision);
        $this->breadth = round($this->breadth, $precision);
        $this->volume = round($this->volume, $precision);
        $this->weight = round($this->weight, $precision);
    }

    /**
     * The item's rotation type setter.
     * The parameter value should be in range between 0 and 5.
     * 
     * @param int $rotationType The item's rotation type, @see RotationCombinationType for the rotation type list.
     * 
     * @return void
     */
    public function setRotationType( $rotationType)
    {
        if (!is_int($rotationType) || $rotationType < 0 || $rotationType > 5) {
            throw new \UnexpectedValueException("Invalid rotation combination type value, the value should be in between 0 and 5.");
        }

        $this->rotationType = $rotationType;
    }

    /**
     * The item's position setter.
     * The parameter value should be an array consisting of 3 values representing the x-axis, y-axis and z-axis.
     * 
     * @param array $position The item's position.
     * 
     * @return void
     */
    public function setPosition(array $position)
    {
        if (count($position) != 3) {
            throw new \UnexpectedValueException("Invalid position value, the value should be an array consisting of 3 values representing the x-axis, y-axis and z-axis.");
        }

        $this->position = $position;
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
