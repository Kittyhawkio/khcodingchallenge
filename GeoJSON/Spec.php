<?php

namespace GeoJSON;

/**
 * The specification for GeoJSON keywords.
 * @link https://geojson.org/ For GeoJSON
 */
class Spec
{
    public const POINT = 'Point';
    public const MULTI_POINT = 'MultiPoint';
    public const LINE_STRING = 'LineString';
    public const MULTI_LINE_STRING = 'MultiLineString';
    public const POLYGON = 'Polygon';
    public const MULTI_POLYGON = 'MultiPolygon';
    public const GEOMETRY_COLLECTION = 'GeometryCollection';

    public const FEATURE = 'Feature';
    public const FEATURE_COLLECTION = 'FeatureCollection';
}
