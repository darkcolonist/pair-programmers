import { ThemeProvider } from '@mui/material/styles';
import { CssBaseline, Grid, Typography } from '@mui/material';
import defaultTheme from './themes/defaultTheme';
import './App.css';
import Dashboard from './components/Dashboard';
import { green } from '@mui/material/colors';

const theme = defaultTheme;

const App = function () {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <Grid container spacing={2}>
        <Grid item xs={12}>
          <Typography variant="h1" sx={{
            color: green[800]
          }}>{APP_NAME}</Typography>
        </Grid>
        <Grid item xs={12}>
          <Dashboard />
        </Grid>
        <Grid item xs={12}>
          <Typography className="footerInfoCode" sx={{
            fontSize: '.8em',
            color: green[900]
          }}>build: {APP_BUILD}</Typography>
        </Grid>
      </Grid>
    </ThemeProvider>
  );
}

export default App;
