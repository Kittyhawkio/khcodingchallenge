// in app.js
import React from 'react';
import { render } from 'react-dom';
import { Admin, Resource } from 'react-admin';
import httpclient from './httpclient';
import { FlightList, FlightEdit, FlightShow, FlightCreate, FlightIcon } from './Flights';

render(
    <Admin dataProvider={httpclient}>
        <Resource name="flights" list={FlightList} show={FlightShow} edit={FlightEdit} create={FlightCreate} icon={FlightIcon}/>
    </Admin>,
    document.getElementById('root')
);
