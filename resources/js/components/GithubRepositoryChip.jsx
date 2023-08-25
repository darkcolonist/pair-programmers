import React from "react";
import GitHubIcon from '@mui/icons-material/GitHub';
import { Chip } from "@mui/material";

export default function GithubRepositoryChip(){
  return <Chip icon={<GitHubIcon />}
    label={"build "+APP_BUILD}
    size="small"
    color="success"
    variant="outlined"
    clickable
    component="a"
    href="https://github.com/darkcolonist/pair-programmers/actions" />
}
