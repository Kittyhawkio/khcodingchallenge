import React from 'react';
import PropTypes from 'prop-types';
import mapboxgl from 'mapbox-gl';

// @TODO: yuck, move to dynamic secret loading?
mapboxgl.accessToken = 'pk.eyJ1Ijoid2VzbmljayIsImEiOiJjazdlM3YyODcwMzJqM25sdTJpcWNjcGpoIn0.GXKILcEwfBi7QZnZ2SBjAw';

const mapStyle = {
    height: '500px',
};

class MapField extends React.Component {

    constructor(props) {
        super(props);

        this.mapRef = React.createRef();
        this.state = {
            lng: props.record.long,
            lat: props.record.lat,
            zoom: 15
        };
    }

    componentDidMount() {
        const { lng, lat, zoom } = this.state;
        const map = new mapboxgl.Map({
            container: this.mapRef.current,
            style: 'mapbox://styles/mapbox/streets-v9',
            center: [lng, lat],
            zoom
        });

        map.on('move', () => {
            const { lng, lat } = map.getCenter();

            this.setState({
                lng: lng.toFixed(4),
                lat: lat.toFixed(4),
                zoom: map.getZoom().toFixed(2)
            });
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
                                    lng,
                                    lat
                                ]
                            },
                            'properties': {
                                'title': 'Scheduled Flight Point',
                                'icon': 'airport'
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
                <div style={mapStyle} ref={this.mapRef} />
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
    zoom: 15,
    lng: 40.759211117,
    lat: -73.97786381,
};


export default MapField;
