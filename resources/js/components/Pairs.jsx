import { Paper, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from "@mui/material";
import { green } from "@mui/material/colors";
import SwapHorizIcon from '@mui/icons-material/SwapHoriz';
import React from "react";

const cellWidth = "200px";

const NormalTableCell = function (props) {
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      width: cellWidth,
      display: "inline-block"
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const EmphasizedTableCell = function(props){
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      color: green[200],
      textTransform: "title",
      width: cellWidth,
      display: "inline-block"
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const TableRows = function({rows, emphasize}){
  if(rows.length === 0)
    return <TableRow>
      <TableCell>empty</TableCell>
    </TableRow>

  const CellComponent = emphasize ? EmphasizedTableCell : NormalTableCell;

  const renderRows = rows.map((row, rowIndex) =>
    <TableRow key={rowIndex}>
      <CellComponent align="right">{row[0]}</CellComponent>
      <CellComponent align="center" width={1}><SwapHorizIcon /></CellComponent>
      <CellComponent>{row[1]}</CellComponent>
    </TableRow>
  )

  return renderRows;
}

const Pairs = function({title, pairs, emphasize = false}){
  return <React.Fragment>
    <Typography variant="h2" sx={{
      color: emphasize ? green[500] : null,
      textTransform: "uppercase"
    }}>{title}</Typography>
    <TableContainer component={Paper}>
      <Table>
        <TableBody>
          <TableRows rows={pairs} emphasize={emphasize} />
        </TableBody>
      </Table>
    </TableContainer>
  </React.Fragment>
}

export default Pairs;
