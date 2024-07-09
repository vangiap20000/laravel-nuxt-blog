import { useBase, createRouter, defineEventHandler } from 'h3';
import { requestApi } from '../../utils';

const router = createRouter();

router.get('/tasks', defineEventHandler(async (event) => await requestApi(event)));
router.post('/tasks', defineEventHandler(async (event) => await requestApi(event)));
router.put('/tasks/:id', defineEventHandler(async (event) => await requestApi(event)));
router.delete('/tasks/:id', defineEventHandler(async (event) => await requestApi(event)));
router.get('/tasks/status', defineEventHandler(async (event) => await requestApi(event)));

export default useBase('/api', router.handler);