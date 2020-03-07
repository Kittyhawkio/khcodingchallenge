import React from 'react';
import { List, Datagrid, SimpleShowLayout, Edit, Show, Create, SimpleForm,
    DateField, RichTextField, NumberField, TextField, EditButton,
    NumberInput, DateTimeInput, TextInput } from 'react-admin';
import RichTextInput from 'ra-input-rich-text';
import FlightWidget from "./FlightWidget";
import MapField from './MapField';
import FlightTakeoffIcon from '@material-ui/icons/FlightTakeoff';
export const FlightIcon = FlightTakeoffIcon;

export const FlightList = (props) => (
    <List {...props}>
        <Datagrid rowClick="show">
            <TextField source="id" />
            <DateField source="flight_time" />
            <NumberField source="lat" options={{ maximumFractionDigits: 6 }} />
            <NumberField source="long" options={{ maximumFractionDigits: 6 }} />
            <NumberField source="duration_in_seconds" />
            <RichTextField source="notes" />
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
            {/*<DateField label="Flight Time" source="flight_time" />*/}
            <MapField source="lat" />
            {/*/!*<NumberField source="lat" options={{ maximumFractionDigits: 6 }} />*!/*/}
            {/*/!*<NumberField source="long" options={{ maximumFractionDigits: 6 }} />*!/*/}
            {/*<NumberField source="duration_in_seconds" />*/}
            {/*<RichTextField source="notes" />*/}
        </SimpleShowLayout>
    </Show>
);

export const FlightEdit = (props) => (
    <Edit title={<FlightTitle />} {...props}>
        <SimpleForm>
            <TextInput disabled source="id" />
            <DateTimeInput label="Flight Time" source="flight_time" />
            <NumberInput source="lat" />
            <NumberInput source="long" />
            <NumberInput source="duration_in_seconds" />
            <RichTextInput source="notes" />
        </SimpleForm>
    </Edit>
);

export const FlightCreate = (props) => (
    <Create title="Create a Flight" {...props}>
        <SimpleForm>
            <DateTimeInput source="flight_time" />
            <NumberInput source="lat" />
            <NumberInput source="long" />
            <NumberInput source="duration_in_seconds" />
            <RichTextInput source="notes" />
        </SimpleForm>
    </Create>
);
