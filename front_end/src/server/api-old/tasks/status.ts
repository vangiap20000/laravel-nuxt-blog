import { defineEventHandler } from 'h3';
import { requestApi } from '../../../utils';

export default defineEventHandler(async (event) => {
  return requestApi(event);
});
