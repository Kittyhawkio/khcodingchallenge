import React from 'react';
import PropTypes from 'prop-types';
import { makeStyles } from '@material-ui/core/styles';
import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import { Alert, AlertTitle } from '@material-ui/lab';
import Typography from '@material-ui/core/Typography';


const useStyles = makeStyles({
    root: {
        minWidth: 275,
    },
    bullet: {
        display: 'inline-block',
        margin: '0 2px',
        transform: 'scale(0.8)',
    },
    title: {
        fontSize: 14,
    },
    pos: {
        marginBottom: 12,
    },
});

const FlightWidget = ({ source, record = {} }) => {
    console.log(record, 'flight widget');
    const classes = useStyles();
    const bull = <span className={classes.bullet}>•</span>;

    return (
        <Card className={classes.root} variant="outlined">
            <CardContent>
                {record.airspace_color !== 'green' &&
                <Alert severity="error">Airspace status: {record.airspace_summary}</Alert>
                }
                {record.airspace_color === 'green' &&
                <Alert severity="success"><AlertTitle>Good to go!</AlertTitle>Airspace status: {record.airspace_summary}</Alert>
                }
                <Typography className={classes.title} color="textSecondary" gutterBottom>
                    {new Intl.DateTimeFormat("en-US", {
                        year: "numeric",
                        month: "long",
                        day: "2-digit"
                    }).format(Date.parse(record.flight_time))}
                </Typography>
                <Typography variant="h5" component="h2">
                    {record.lat},{record.long}
                </Typography>
                <Typography className={classes.pos} color="textSecondary">
                    Weather: {record.weather_summary} ({record.temperature}F)
                </Typography>

            </CardContent>
        </Card>
    );
};

FlightWidget.propTypes = {
    record: PropTypes.object,
    source: PropTypes.string.isRequired,
};

export default FlightWidget;

