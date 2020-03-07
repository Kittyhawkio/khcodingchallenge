import React from 'react';
import PropTypes from 'prop-types';
import mapboxgl from 'mapbox-gl';

// @TODO: yuck, move to dynamic secret loading?
mapboxgl.accessToken = 'pk.eyJ1Ijoid2VzbmljayIsImEiOiJjazdlM3YyODcwMzJqM25sdTJpcWNjcGpoIn0.GXKILcEwfBi7QZnZ2SBjAw';
//
// const MapField = ({ props, source, record = {} }) => {
//     console.log(source, 'source');
//     console.log(props, 'props');
//     let map = new mapboxgl.Map({
//         container: this.mapContainer,
//         style: 'mapbox://styles/mapbox/streets-v11',
//         center: [this.state.lng, this.state.lat],
//         zoom: this.state.zoom
//     });
//
//     return (
//         <div>
//             <div ref={el => map = el} />
//         </div>
//     )
// };

class MapField extends React.Component {

    constructor(props) {
        super(props);
        console.log(props, 'mapbox props');
        this.state = {
            lng: props.record.long,
            lat: props.record.lat,
            zoom: 8
        };
        this.mapRef = React.createRef();
    }

    componentDidMount() {
        const { lng, lat, zoom } = this.state;

        const map = new mapboxgl.Map({
            container: this.mapRef.current,
            style: 'mapbox://styles/mapbox/streets-v9',
            center: [lng, lat],
            zoom
        });

        map.on('load', function() {
            map.addSource('points', {
                'type': 'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': [
                        {
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Point',
                                'coordinates': [
                                    -77.03238901390978,
                                    38.913188059745586
                                ]
                            },
                            'properties': {
                                'title': 'Schedule Flight Point',
                                'icon': 'drone'
                            }
                        }
                    ]
                }
            });
            map.addLayer({
                'id': 'points',
                'type': 'symbol',
                'source': 'points',
                'layout': {
// get the icon name from the source's "icon" property
// concatenate the name to get an icon from the style's sprite sheet
                    'icon-image': ['concat', ['get', 'icon'], '-15'],
// get the title name from the source's "title" property
                    'text-field': ['get', 'title'],
                    'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
                    'text-offset': [0, 0.6],
                    'text-anchor': 'top'
                }
            });
        });
    }

    render() {
        const { lng, lat, zoom } = this.state;

        return (
            <div>
                <div>
                    <div>{`Longitude: ${lng} Latitude: ${lat} Zoom: ${zoom}`}</div>
                </div>
                <div ref={this.mapRef} />
            </div>
        );
    }
}


MapField.propTypes = {
    zoom: PropTypes.number.isRequired,
    lng: PropTypes.number.isRequired,
    lat: PropTypes.number.isRequired,
};

MapField.defaultProps = {
    zoom: 2,
    lng: 40.759211117,
    lat: -73.97786381,
};


export default MapField;
