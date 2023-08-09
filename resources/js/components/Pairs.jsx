import { Paper, Table, TableBody, TableCell, TableContainer, TableRow, Typography } from "@mui/material";
import { green, grey } from "@mui/material/colors";
import SwapHorizIcon from '@mui/icons-material/SwapHoriz';
import React from "react";

const cellWidth = "150px";
const smallCellWidth = "25px";

const NormalTableCell = function (props) {
  return <TableCell {...props}
    style={{
      ...props.style,
      borderBottom: 'none'
    }}>
    <Typography variant="p" sx={{
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block",
      color: grey[500]
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const EmphasizedTableCell = function(props){
  return <TableCell {...props}>
    <Typography variant="h3" sx={{
      color: green[200],
      textTransform: "capitalize",
      width: props.small ? smallCellWidth : cellWidth,
      display: "inline-block"
    }}>
      {props.children}
    </Typography>
  </TableCell>
}

const TableRows = function({rows, emphasize}){
  const CellComponent = emphasize ? EmphasizedTableCell : NormalTableCell;

  if(rows.length === 0)
    return <TableRow>
      <CellComponent align="center">table empty</CellComponent>
    </TableRow>

  const renderRows = rows.map((row, rowIndex) =>
    <TableRow key={rowIndex}>
      <CellComponent align="right">{row[0]}</CellComponent>
      <CellComponent align="center" small={1} style={{
        width: smallCellWidth,
        padding: "0px"
      }}><SwapHorizIcon /></CellComponent>
      <CellComponent>{row[1]}</CellComponent>
    </TableRow>
  )

  return renderRows;
}

const Pairs = function({title, pairs = [], emphasize = false}){
  const tableContainerProps = emphasize ?
    {
      component: Paper,
      elevation: 1
    } :
    {}

  const tableProps = emphasize ?
    {} :
    {
      size: "small"
    }

  return <React.Fragment>
    <Typography variant={emphasize ? "h2" : "h4"} sx={{
      color: emphasize ? green[500] : grey[600],
      textTransform: emphasize ? "uppercase" : "capitalize"
    }}>{title}</Typography>
    <TableContainer {...tableContainerProps}>
      <Table {...tableProps}>
        <TableBody>
          <TableRows rows={pairs} emphasize={emphasize} />
        </TableBody>
      </Table>
    </TableContainer>
  </React.Fragment>
}

export default Pairs;
