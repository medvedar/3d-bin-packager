<?php

/**
 * 3D Bin Packager
 *
 * @license   MIT
 * @author    Farista Latuconsina
 * @author    Maksym Medar
 */

namespace Latuconsinafr\BinPackager\BinPackager3D\Types;

/**
 * Enum of possible positions.
 */
class PositionType
{
    // Start position
    const START_POSITION = [
        AxisType::LENGTH  => 0,
        AxisType::HEIGHT  => 0,
        AxisType::BREADTH => 0,
    ];
}
