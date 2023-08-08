import { ThemeProvider } from '@mui/material/styles';
import { CssBaseline } from '@mui/material';
import defaultTheme from './themes/defaultTheme';
import SomeComponent from './components/SomeComponent';

const theme = defaultTheme;

const App = function () {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <SomeComponent />
    </ThemeProvider>
  );
}

export default App;
