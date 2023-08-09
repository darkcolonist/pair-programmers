import { Skeleton, Table, TableBody, TableCell, TableContainer, TableRow } from "@mui/material"

const LoadingTable = ({ rowsNum = 5, columnsNum = 5, ...props }) => {
  const columns = [...Array(columnsNum)].map((col, cIndex) => (
    <TableCell key={cIndex} component="th" scope="row">
      <Skeleton animation="wave" variant="text" />
    </TableCell>
  ));

  const rows = ([...Array(rowsNum)].map((row, index) => (
    <TableRow key={index}>
      {columns}
    </TableRow>
  )));

  return <TableContainer {...props}>
    <Table>
      <TableBody>
        {rows}
      </TableBody>
    </Table>
  </TableContainer>
};

export default LoadingTable
