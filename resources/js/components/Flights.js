import React from 'react';
import { List, Datagrid, SimpleShowLayout, Edit, Show, Create, SimpleForm,
    DateField, RichTextField, NumberField, TextField, EditButton,
    NumberInput, DateTimeInput, TextInput } from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import FlightWidget from "./FlightWidget";
import FlightTakeoffIcon from '@material-ui/icons/FlightTakeoff';
export const FlightIcon = FlightTakeoffIcon;
import {
    required,
    minValue,
    maxValue,
    number
} from 'react-admin';

// Validation
const validateLat = [number(), minValue(-90), maxValue(90)];
const validateLong = [number(), minValue(-180), maxValue(180)];
const validateDuration = [number(), required(), minValue(1), maxValue(99999)];
const validateNotes = [required()];
const validateFlightTime = (value) => {
    const flightTime = new Date(value);

    if (!flightTime instanceof Date) {
        return 'Please choose a valid date';
    }

    const now = new Date();
    if (flightTime < now) {
        return 'Please choose a date in the future'
    }

    return undefined;
};

export const FlightList = (props) => (
    <List title="KittyHawk" {...props}>
        <Datagrid rowClick="show">
            <TextField source="id" />
            <DateField source="flight_time" />
            <NumberField source="lat" options={{ maximumFractionDigits: 6 }} />
            <NumberField source="long" options={{ maximumFractionDigits: 6 }} />
            <NumberField source="duration_in_seconds" />
            <TextField source="weather_summary"/>
            <TextField source="airspace_summary"/>
            {/*<RichTextField source="notes" />*/}
            <EditButton basePath="/Flights" />
        </Datagrid>
    </List>
);

const FlightTitle = ({ record }) => {
    return <span>Flight {record ? `"${record.id}"` : ''}</span>;
};

export const FlightShow = (props) => (
    <Show {...props}>
        <SimpleShowLayout>
            <FlightWidget source="id" />
        </SimpleShowLayout>
    </Show>
);

export const FlightEdit = (props) => (
    <Edit title={<FlightTitle />} {...props}>
        <SimpleForm redirect="show">
            <TextInput disabled source="id" />
            <DateTimeInput label="Flight Time" source="flight_time" validate={validateFlightTime} />
            <NumberInput source="lat" validate={validateLat} />
            <NumberInput source="long" validate={validateLong} />
            <NumberInput source="duration_in_seconds" validate={validateDuration} />
            <RichTextInput source="notes" validate={validateNotes }/>
        </SimpleForm>
    </Edit>
);

export const FlightCreate = (props) => (
    <Create title="Create a Flight" {...props}>
        <SimpleForm redirect="show">
            <DateTimeInput source="flight_time" validate={validateFlightTime} />
            <NumberInput source="lat" validate={validateLat} />
            <NumberInput source="long" validate={validateLong} />
            <NumberInput source="duration_in_seconds" validate={validateDuration} />
            <RichTextInput source="notes" validate={validateNotes }/>
        </SimpleForm>
    </Create>
);
