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
          {/* <Dashboard /> */}
          <Typography sx={{
            color: "darkgreen"
          }}>
            currently in the works, meantime please check discord for the updated pair-ups
          </Typography>
        </Grid>
      </Grid>
    </ThemeProvider>
  );
}

export default App;
