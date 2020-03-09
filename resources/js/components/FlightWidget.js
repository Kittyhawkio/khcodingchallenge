import React from 'react';
import PropTypes from 'prop-types';
import { makeStyles } from '@material-ui/core/styles';
import { Alert, AlertTitle } from '@material-ui/lab';
import Typography from '@material-ui/core/Typography';
import Paper from '@material-ui/core/Paper';
import Grid from '@material-ui/core/Grid';
import MapField from "./MapField";

const useStyles = makeStyles(theme => ({
    root: {
        flexGrow: 1,
    },
    paper: {
        padding: theme.spacing(2),
        textAlign: 'center',
        color: theme.palette.text.secondary,
    },
}));

const FlightWidget = ({ source, record = {} }) => {
    const classes = useStyles();

    return (
        <div className={classes.root}>
            <Grid container spacing={3}>
                <Grid item xs={6} sm={4}>
                    <Paper className={classes.paper}>
                        {record.airspace_color !== 'green' &&
                        <Alert severity="error">Airspace status: {record.airspace_summary}</Alert>
                        }
                        {record.airspace_color === 'green' &&
                        <Alert severity="success"><AlertTitle>Good to go!</AlertTitle>Airspace status: {record.airspace_summary}</Alert>
                        }
                        <Typography component="h3" variant="h3">
                            {new Intl.DateTimeFormat("en-US", {
                                hour: "numeric",
                                minute: "numeric",
                                second: "numeric"
                            }).format(Date.parse(record.flight_time))}
                        </Typography>
                        <Typography component="h3" variant="h5">
                            {new Intl.DateTimeFormat("en-US", {
                                year: "numeric",
                                month: "long",
                                day: "2-digit"
                            }).format(Date.parse(record.flight_time))}
                        </Typography>
                        <Typography component="h5" variant="h5">
                            {record.lat},{record.long}
                        </Typography>
                        <Typography component="h4" variant="h5">
                            Weather: {record.weather_summary} ({record.temperature}F)
                        </Typography>
                    </Paper>
                </Grid>
                <Grid item xs={6} sm={8}>
                    <Paper className={classes.paper}>
                        <MapField record={record} source={source}/>
                    </Paper>
                </Grid>
            </Grid>
        </div>
    );
};

FlightWidget.propTypes = {
    record: PropTypes.object,
    source: PropTypes.string.isRequired,
};

export default FlightWidget;

