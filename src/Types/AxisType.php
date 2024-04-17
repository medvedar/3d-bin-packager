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
 * Enum of possible axises.
 */
class AxisType
{
    // Represents the 3d-plane axis
    const LENGTH = 'x-axis';
    const HEIGHT = 'y-axis';
    const BREADTH = 'z-axis';

    // Enum contains all the 3d-plane axis
    const ALL_AXIS = [
        AxisType::LENGTH,
        AxisType::HEIGHT,
        AxisType::BREADTH,
    ];
}
